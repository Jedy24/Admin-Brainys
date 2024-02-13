<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\UserMaterial;

class UserMaterialController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'UserMaterial';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        $grid = new Grid(new UserMaterial());

        $grid->column('id', __('Id'));
        $grid->column('user_name', __('User Name'));
        $grid->column('name', __('Generate Name'));
        $grid->column('user_id', __('Generate Count'));

        return $grid;
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(UserMaterial::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_name', __('User Name'));
        $show->field('name', __('Generate Name'));
        $show->field('user_id', __('Generate Count'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new UserMaterial());

        $form->text('user_name', __('User Name'));
        $form->text('name', __('Generate Name'));
        $form->number('user_id', __('Generate Count'));

        return $form;
    }
}
