<?php

namespace Engelsystem\Twig;

use Twig\NodeVisitor\AbstractNodeVisitor;

class PermissionNodeVisitor extends AbstractNodeVisitor
{
    private $enabled = false;
    private $permissions = [];

    public function enable()
    {
        $this->enabled = true;
        $this->permissions = [];
    }

    public function disable()
    {
        $this->enabled = false;
        $this->permissions = [];
    }

    public function getPermissions()
    {
        return array_keys(array_flip($this->permissions));
    }

    /**
     * {@inheritdoc}
     */
    protected function doEnterNode(\Twig_Node $node, \Twig_Environment $env)
    {
        if ($this->enabled === false) {
            return $node;
        }

        if ($node instanceof \Twig_Node_Expression_Function && $node->getAttribute('name') === 'hasPermission') {
            $arguments = $node->getNode('arguments');
            $this->permissions[] = $arguments->getNode(0)->getAttribute('value');
        }

        return $node;
    }

    /**
     * {@inheritdoc}
     */
    protected function doLeaveNode(\Twig_Node $node, \Twig_Environment $env)
    {
        return $node;
    }

    /**
     * {@inheritdoc}
     */
    public function getPriority()
    {
        return 0;
    }
}
