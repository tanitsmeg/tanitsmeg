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

class CustomBlockService extends BaseBlockService {

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
        
        $content = $this->container->get('dn.tm.manager.page_block')->getContentForBlock($settings['block'], $settings['blockFilters']);

        return $this->renderResponse($blockContext->getTemplate(), array(
                    'content' => $content,
                    'block' => $blockContext->getBlock(),
                    'settings' => $blockContext->getSettings()
                        ), $response
        );
    }

    /**
     * {@inheritdoc}
     */
    public function validateBlock(ErrorElement $errorElement, BlockInterface $block) {
        // TODO: Implement validateBlock() method.
    }

    /**
     * {@inheritdoc}
     */
    public function buildEditForm(FormMapper $formMapper, BlockInterface $block) {
        $formMapper->add('settings', 'sonata_type_immutable_array', array(
            'keys' => array(
                array('content', 'textarea', array()),
            )
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getName() {
        return 'dn.tm.block.custom';
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultSettings(OptionsResolverInterface $resolver) {
        $params = array(
            'request' => null,
            'blockFilters' => null,
            'block' => null,
            'template' => 'DNTMBundle:Block:custom.html.twig',
        );

        $resolver->setDefaults($params);
    }

}
