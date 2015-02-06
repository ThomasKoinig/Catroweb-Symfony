<?php
namespace Catrobat\AppBundle\Admin;

use Sonata\AdminBundle\Admin\Admin;
use Sonata\AdminBundle\Datagrid\ListMapper;
use Sonata\AdminBundle\Datagrid\DatagridMapper;
use Sonata\AdminBundle\Form\FormMapper;
use Catrobat\AppBundle\Entity\User;
use Catrobat\AppBundle\Entity\Project;
use Sonata\AdminBundle\Route\RouteCollection;

class ReportedProgramsAdmin extends Admin
{

  public function createQuery($context = 'list')
  {
    $query = parent::createQuery($context);
    return $query;
  }

//  TODO: Log who accepted/rejected
//  public function preUpdate($program)
//  {
//    $old_program = $this->getModelManager()->getEntityManager($this->getClass())->getUnitOfWork()->getOriginalEntityData($program);
//
//    if($old_program["approved"] == false && $program->getApproved() == true)
//    {
//      $program->setApprovedByUser($this->getConfigurationPool()->getContainer()->get('security.context')->getToken()->getUser());
//      $this->getModelManager()->update($program);
//    }elseif($old_program["approved"] == true && $program->getApproved() == false)
//    {
//      $program->setApprovedByUser(null);
//      $this->getModelManager()->update($program);
//    }
//  }


  // Fields to be shown on filter forms
  protected function configureDatagridFilters(DatagridMapper $datagridMapper)
  {
//    $datagridMapper
//        ->add('name')
//        ->add('user')
//    ;
  }

  // Fields to be shown on lists
  protected function configureListFields(ListMapper $listMapper)
  {
    $listMapper
        ->add('state',
        'choice',
        array('choices' => Array(1=>"NEW",2=>"ACCEPTED",3=>"REJECTED") ,'editable' => true))
        ->add('time')
        ->add('note')
        ->add('reportingUser', 'entity', array('class' => 'Catrobat\AppBundle\Entity\User'))
        ->add('project', 'entity', array('class' => 'Catrobat\AppBundle\Entity\Program', 'admin_code' => 'catrowebadmin.block.programs.all'))
        ->add('project.approved', 'boolean', array('editable' => false))
        ->add('project.visible', 'boolean', array('editable' => true))
        ->add('_action', 'actions', array('actions' => array('show' => array(),'edit' => array())))
    ;
  }


  // Fields to be shown on create/edit forms
  protected function configureFormFields(FormMapper $formMapper)
  {
    $formMapper
        ->add('state',
            'choice',
            array('choices' => Array(1=>"NEW",2=>"ACCEPTED",3=>"REJECTED")))
        ->add('project.visible','choice', array(
      'choices' => array(
          '0' => 'No',
          '1' => 'Yes',
      ),
      'required' => true,))
    ;
  }

  protected function configureRoutes(RouteCollection $collection)
  {
    $collection->remove('create')->remove('delete');
  }
}

