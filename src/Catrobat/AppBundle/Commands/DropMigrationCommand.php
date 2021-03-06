<?php

namespace Catrobat\AppBundle\Commands;

use Catrobat\AppBundle\Entity\MigrationManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DropMigrationCommand extends ContainerAwareCommand
{
  private $output;
  private $migration_manager;

  public function __construct(MigrationManager $migration_manager)
  {
    parent::__construct();
    $this->migration_manager = $migration_manager;
  }

  protected function configure()
  {
    $this->setName('catrobat:drop:migration')
         ->setDescription('Dropping the migration_versions table');
  }

  protected function execute(InputInterface $input, OutputInterface $output)
  {
    $this->output = $output;
    if ($this->migration_manager->dropMigrationVersions())
    {
      $this->output->writeln('Table migration_versions dropped!');
    }
    else
    {
      $this->output->writeln('Table migration_versions doesn\'t exist!');
    }
  }
} 