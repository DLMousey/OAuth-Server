<?php

namespace Core\Service;

use Core\Mapper\ScopeMapper;

class ScopeService
{
    protected $scopeMapper;

    /**
     * @param int $id
     * @return Scope|null
     */
    public function find(int $id)
    {
        return $this->getScopeMapper()->find($id);
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function findByName(string $name)
    {
        return $this->getScopeMapper()->findOneByName(strtolower($name));
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function findByKey(string $key)
    {
        return $this->getScopeMapper()->findOneByKey(strtolower($key));
    }

    /**
     * @param ScopeMapper $scopeMapper
     * @return $this
     */
    public function setScopeMapper(ScopeMapper $scopeMapper)
    {
        $this->scopeMapper = $scopeMapper;
        return $this;
    }

    /**
     * @return ScopeMapper
     */
    public function getScopeMapper() : ScopeMapper
    {
        return $this->scopeMapper;
    }
}
