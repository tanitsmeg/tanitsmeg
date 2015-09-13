<?php

namespace DN\TMBundle\Block;

use Sonata\BlockBundle\Block\BlockContextInterface;
use Symfony\Component\HttpFoundation\Response;
use Sonata\AdminBundle\Form\FormMapper;
use Sonata\AdminBundle\Validator\ErrorElement;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\BlockBundle\Block\BaseBlockService;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;
use Doctrine\ORM\EntityManager;

class NewsletterBlockService extends BaseBlockService {

    private $em;
    private $container;

    public function __construct($name, EngineInterface $templating, EntityManager $entityManager, Container $container) {
        parent::__construct($name, $templating);
        $this->container = $container;
        $this->em = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function execute(BlockContextInterface $blockContext, Response $response = null) {
        $settings = $blockContext->getSettings();
        
        $form = $this->getForm();
        $formSaveSuccess = false;

        if ($settings['request'] != null) {
            $request = $settings['request'];
            $form->handleRequest($request);

            if ($form->isValid()) {
                $formSaveSuccess = $this->em->getRepository('DNTMBundle:CustomFormData')->saveForm($form->getData(), $this->getName());
            }
        }

        $template = $blockContext->getTemplate();

        return $this->renderResponse($template, array(
                    'form' => $form->createView(),
                    'formSaveSuccess' => $formSaveSuccess,
                    'block' => $blockContext->getBlock(),
                    'settings' => $blockContext->getSettings()
                        ), $response
        );
    }

    /**
     * {@inheritdoc}
     */
    public function validateBlock(ErrorElement $errorElement, BlockInterface $block) {

    }

    public function buildEditForm(FormMapper $formMapper, BlockInterface $block) {

    }

    /**
     * {@inheritdoc}
     */
    public function getName() {
        return 'dn.tm.block.newsletter';
    }

    private function getForm() {
        $formFactory = $this->container->get('form.factory');
        $form = $formFactory->create($this->container->get('dn.tm.form.type.newsletter'));

        return $form;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver) {
        $params = array(
            'request' => null,
            'blockFilters' => null,
            'block' => null,
            'template' => 'DNTMBundle:Block:newsletter2.html.twig',
        );

        $resolver->setDefaults($params);
    }

}
