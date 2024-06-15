<?php


use WEB\Controller\Core\PackageController;
use WEB\Manager\Env\EnvManager;
use WEB\Utils\Utils;

?>
<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header text-center">
            <div class="logo">
                <a href="<?= EnvManager::getInstance()->getValue("PATH_SUBFOLDER") ?>admin/dashboard">
                    <img src="<?= EnvManager::getInstance()->getValue("PATH_SUBFOLDER") ?>Admin/Resources/Assets/Images/Logo/logo_compact.png"
                         alt="Logo">
                </a>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Général</li>
                <li class="sidebar-item <?= Utils::isActiveNavbarItem('dashboard') ? 'active' : '' ?>">
                    <a href="<?= EnvManager::getInstance()->getValue("PATH_SUBFOLDER") ?>admin/dashboard"
                       class="sidebar-link">
                        <i class="fa-solid fa-table-columns"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <?php
                foreach (PackageController::getCorePackages() as $package):
                    foreach ($package->menus() as $menu):
                        if (is_null($menu->getUrl())):?>
                            <li class="sidebar-item has-sub <?= Utils::isActiveNavbar($menu->getSubMenus()) ? 'active' : '' ?>">
                                <a href="#" class="sidebar-link">
                                    <i class="<?= $menu->getIcon() ?>"></i>
                                    <span><?= $menu->getTitle() ?></span>
                                </a>
                                <ul class="submenu <?= Utils::isActiveNavbar($menu->getSubMenus()) ? 'active' : '' ?>">
                                    <?php foreach ($menu->getSubMenus() as $submenu): ?>
                                        <li class="submenu-item <?= Utils::isActiveNavbarItem($submenu->getUrl()) ? 'active' : '' ?>">
                                            <a href="<?= EnvManager::getInstance()->getValue("PATH_SUBFOLDER") ?>admin/<?= $submenu->getUrl() ?>">
                                                <?= $submenu->getTitle() ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        <?php else: ?>
                            <li class="sidebar-item <?= Utils::isActiveNavbarItem($menu->getUrl()) ? 'active' : '' ?>">
                                <a href="<?= EnvManager::getInstance()->getValue("PATH_SUBFOLDER") ?>admin/<?= $menu->getUrl() ?>"
                                   class="sidebar-link">
                                    <i class="<?= $menu->getIcon() ?>"></i>
                                    <span><?= $menu->getTitle() ?></span>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>

                <li class="sidebar-title">Packages</li>

                <?php foreach (PackageController::getInstalledPackages() as $package):
                    foreach ($package->menus() as $menu):
                        if (is_null($menu->getUrl())):?>
                            <li class="sidebar-item has-sub <?= Utils::isActiveNavbar($menu->getSubMenus()) ? 'active' : '' ?>">
                                <a href="#" class="sidebar-link">
                                    <i class="<?= $menu->getIcon() ?>"></i>
                                    <span><?= $menu->getTitle() ?></span>
                                </a>
                                <ul class="submenu <?= Utils::isActiveNavbar($menu->getSubMenus()) ? 'active' : '' ?>">
                                    <?php foreach ($menu->getSubMenus() as $submenu): ?>
                                        <li class="submenu-item <?= Utils::isActiveNavbarItem($submenu->getUrl()) ? 'active' : '' ?>">
                                            <a href="<?= EnvManager::getInstance()->getValue("PATH_SUBFOLDER") ?>admin/<?= $submenu->getUrl() ?>">
                                                <?= $submenu->getTitle() ?>
                                            </a>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </li>
                        <?php else: ?>
                            <li class="sidebar-item <?= Utils::isActiveNavbarItem($menu->getUrl()) ? 'active' : '' ?>">
                                <a href="<?= EnvManager::getInstance()->getValue("PATH_SUBFOLDER") ?>admin/<?= $menu->getUrl() ?>"
                                   class="sidebar-link">
                                    <i class="<?= $menu->getIcon() ?>"></i>
                                    <span><?= $menu->getTitle() ?></span>
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</div>