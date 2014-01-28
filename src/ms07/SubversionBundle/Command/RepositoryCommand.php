<?php

namespace ms07\SubversionBundle\Command;

use Doctrine\ODM\MongoDB\Cursor;
use Doctrine\ODM\MongoDB\DocumentManager;
use ms07\SubversionBundle\Document\Author;
use ms07\SubversionBundle\Document\Path;
use ms07\SubversionBundle\Document\Repository;
use ms07\SubversionBundle\Document\Revision;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class RepositoryCommand extends ContainerAwareCommand{
	protected function configure(){
		$this->setName('subversion:repository')
			->setDescription("fetch repository information")
			->addOption('info', null, InputOption::VALUE_NONE, "if set then only display information about the repository")
			->addArgument('id', InputArgument::REQUIRED, "repository id - 'all' to process all entries");
	}

	protected function execute(InputInterface $input, OutputInterface $output){
		/**
		 * @var DocumentManager $mongo
		 */
		$mongo = $this->getContainer()->get('doctrine_mongodb')->getManager();

		$id = $input->getArgument('id');

		if($id==='all'){
			foreach($mongo->getRepository('SubversionBundle:Repository')->findBy(array('validated' => true)) as $repository){
				$this->handleRepository(
					$repository,
					$input,
					$output
				);
			}
		}else{
			$this->handleRepository(
				$mongo->getRepository('SubversionBundle:Repository')->find($id),
				$input,
				$output
			);
		}
	}

	protected function handleRepository(Repository $repository, InputInterface $input, OutputInterface $output){
		if(!$repository->getValidated()){
			$output->writeln("<error>invalid repository: {$repository->getName()} ({$repository->getId()})</error>");
			return;
		}

		$info = $this->getInfo($repository);

		if($input->getOption("info")){

			$output->writeln("<info>UUID:</info> {$info['repository uuid']}");
			$output->writeln("<info>Root:</info> {$info['repository root']}");
			$output->writeln("<info>Revisions:</info> {$info['revision']}");

			return;
		}

		/**
		 * @var DocumentManager $mongo
		 */
		$mongo = $this->getContainer()->get('doctrine_mongodb')->getManager();

		/**
		 * @var Cursor $cursor
		 */
		$cursor = $mongo->getRepository('SubversionBundle:Revision')
			->createQueryBuilder()
			->field('repository.$id')->equals(new \MongoId($repository->getId()))
			->sort('number', 'DESC')
			->getQuery()
			->execute();

		$cursor->next();
		$revision = $cursor->current();
		$repository->setLastRevision($revision);

		if($repository->getLastRevision()!==null){
			$first = $repository->getLastRevision()->getNumber()+1;
		}else{
			$first = 1;
		}

		if($info['revision']<$first){
			$output->writeln("reached end");
			return;
		}

		for($current = $first; $current<$first+100; $current++){
			$output->writeln("working on revision <info>{$current}</info>");
			$this->buildRevision($repository, $current);
		}

		$mongo->flush();
	}

	/**
	 * @param Repository $repository
	 * @param int $number
	 */
	protected function buildRevision(Repository $repository, $number){
		/**
		 * @var DocumentManager $mongo
		 */
		$mongo = $this->getContainer()->get('doctrine_mongodb')->getManager();

		$cmd = 'svn diff --non-interactive --trust-server-cert --username '.escapeshellarg($repository->getUser()).' --password '.escapeshellarg($repository->getPassword());
		$cmd.= ' '.$repository->getBasePath().' -r'.$number.'|diffstat -f 0 -m -q';

		$diff = `$cmd`;
		$info = $this->getInfo($repository, $number);

		$author = $mongo->getRepository('SubversionBundle:Author')->findOneBy(array('internal'=>$info['last changed author']));

		if(empty($author)){
			$author = new Author();
			$author->setRepository($repository);
			$author->setInternal($info['last changed author']);
			$mongo->persist($author);
		}

		$tmp = explode(' (', $info['last changed date']);
		$created = array_shift($tmp);

		$revision = new Revision();
		$revision->setRepository($repository);
		$revision->setNumber($number);
		$revision->setCreated(new \DateTime($created));
		$revision->setAuthor($author);
		$repository->setLastRevision($revision);
		$mongo->persist($revision);
		$mongo->persist($repository);

		if(empty($diff)){
			return;
		}

		foreach(explode("\n", $diff) as $line){
			$parts = explode('|', $line, 2);

			if(empty($parts[1])){
				continue;
			}

			preg_match("!\s+([0-9]+) \+\s+([0-9]+) \-\s+([0-9]+) \!!i", $parts[1], $found);

			if(count($found)!=4){
				continue;
			}

			$path = new Path();
			$path->setRevision($revision);
			$path->setRepository($repository);
			$path->setPath(trim($parts[0]));
			$path->setStatChange($found[3]);
			$path->setStatDelete($found[2]);
			$path->setStatInsert($found[1]);
			$mongo->persist($path);

			$revision->getPathList()->add($path);
		}
	}

	/**
	 * @param Repository $repository
	 * @return array
	 */
	protected function getInfo(Repository $repository, $number=null){
		$result = array();

		$cmd = 'svn info --non-interactive --trust-server-cert --username '.escapeshellarg($repository->getUser()).' --password '.escapeshellarg($repository->getPassword());
		$cmd.= ' '.$repository->getBasePath();

		if($number>0){
			$cmd.= ' -r'.$number;
		}

		$raw = `$cmd`;

		foreach(explode("\n", $raw) as $row){
			if(empty($row)){
				continue;
			}

			$parts = explode(':', $row, 2);

			if(empty($parts[1])){
				continue;
			}

			$result[strtolower(trim($parts[0]))] = trim($parts[1]);
		}

		return $result;
	}
}
