<?php

namespace AppBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Knp\Menu\ItemInterface;
class Builder
{
    private $factory;

    /**
     * @param FactoryInterface $factory
     */
    public function __construct(FactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    private function defaultOptions($options){
        return array_merge([
            'icon'          => '',
            'role'          => [],
            'isGrantedType' => true,
        ], $options);
    }

    /**
     * @param ItemInterface    $menu
     * @param array            $nav
     * @param SecurityContext  $security
     */
    private function menuCreator(ItemInterface &$menu, array $nav, SecurityContext &$security, $level=0)
    {
    /**
     * @var  $route
     */
        foreach ($nav as $route => $options) {
            $options = $this->defaultOptions($options);
            if(!empty($options['role'])) {
                $check = $options['isGrantedType'] ? $security->isGranted($options['role'])
                    : !$security->isGranted($options['role']);
            } else

                $check = true;
            /** bool $check */
            if ($check) {
                $route = $route[0]!='#' ? ['route' => $route]
                                        : [];
                $menu->addChild($options['name'], $route)
                    ->setAttribute('icon', $options['icon']);

                if (isset($options['child'])) {
                    $menu[$options['name']]
                        ->setAttribute('dropdown', true)
                        ->setAttribute('icon', $options['icon'])
                        ->setAttribute('class', $level>0?'dropdown-submenu':'')
                    ;
                    $this->menuCreator($menu[$options['name']], $options['child'], $security, $level+1);
                }
            }
        }
    }

    /**
     * @param SecurityContext $security
     *
     *
     * @return \Knp\Menu\ItemInterface
     */
    public function mainMenu(SecurityContext $security)
    {
        $menu = $this->factory->createItem('root', [
            'subnavbar' => true,
        ]);
        $menu->setChildrenAttributes([
            'class' => 'nav navbar-nav navbar-left',
        ]);


        $nav = [
            '#modify' => [
                'name' => 'Modify',
                'child' => [
                    '#list-reasons' => [
                        'name' => 'Reasons',
                        'child' => [
                            'listreason_new' => [
                                'name' => 'new listreason',
                            ],
                            'listreason' => [
                                'name' => 'listreasons',
                            ],
                        ],
                    ],
                    'app_bundle_hello' => [
                        'name' => 'Family',
                    ],
                ],
            ],
            'app_bundle_homepage' => [
                'name' => 'About me'
            ],
        ];

        $this->menuCreator($menu, $nav, $security);

        return $menu;
    }
}
