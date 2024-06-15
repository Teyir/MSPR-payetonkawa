<?php


namespace WEB\Manager\Permission;

interface IPermissionInit
{

    /**
     * @return \WEB\Manager\Permission\PermissionInitType[]
     */
    public function permissions(): array;
}