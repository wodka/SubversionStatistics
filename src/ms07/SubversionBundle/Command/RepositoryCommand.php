<?php

namespace ms07\SubversionBundle\Command;

use Doctrine\ODM\MongoDB\DocumentManager;
use ms07\SubversionBundle\Document\Repository;
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
/*
		$r = new Repository();

		$r->setBasePath('https://svn.pointofus.com/pointofus');
		$r->setUser('michael.schramm');
		$r->setPassword('Michael1987');
		$r->setValidated(true);

		$r->setName('Point of Us - Main Repository');

		$mongo->persist($r);
		$mongo->flush();
*/
	}

	protected function handleRepository(Repository $repository, InputInterface $input, OutputInterface $output){
		var_dump($repository);

		if(!$repository->getValidated()){
			$output->writeln("<error>invalid repository: {$repository->getName()} ({$repository->getId()})</error>");
			return;
		}


		$repository = '';
		$user = 'michael.schramm';
		$password = 'Michael1987';


		if($input->getOption("info")){

			$cmd = 'svn info --non-interactive --trust-server-cert --username '.escapeshellarg($user).' --password '.escapeshellarg($password);
			$cmd.= ' '.$repository;


			var_dump($cmd);

			echo `$cmd`;
		}
	}
}
