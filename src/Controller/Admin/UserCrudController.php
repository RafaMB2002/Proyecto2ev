<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureFields(string $pageName): iterable
    {
        /* if(Crud::PAGE_EDIT == 'edit'){
            return [
                IdField::new('id'),
                TextField::new('nombre'),
                TextField::new('apellidos'),
                TextField::new('email'),
                ImageField::new('avatar')->setUploadDir('public\img\avatar')
            ];
        } */
        return [
            IdField::new('id'),
            TextField::new('nombre'),
            TextField::new('apellidos'),
            TextField::new('email'),
            ImageField::new('avatar')->setBasePath('img/avatar')
        ];
    }
}
