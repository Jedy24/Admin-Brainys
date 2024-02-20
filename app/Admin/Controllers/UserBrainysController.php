<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\UserBrainys;
use Illuminate\Database\Seeder;
use DB;

class UserBrainysController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'UserBrainys';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return new Grid(new UserBrainys(), function (Grid $grid) {
            $grid->column('id', __('Id'));
            $grid->column('name', __('Name'));
            $grid->column('email', __('Email'));
            $grid->column('profession', __('Profession'));
            $grid->column('school_name', __('School name'));

            // Add your custom button next to the filter button
            $grid->tools(function (Grid\Tools $tools) {
                $tools->append('<a href="' . route('admin.user-brainys.seed') . '" class="btn btn-sm btn-success">Insert Data</a>');
            });
        });
    }

    /**
     * Make a show builder.
     *
     * @param mixed $id
     * @return Show
     */
    protected function detail($id)
    {
        $show = new Show(UserBrainys::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('name', __('Name'));
        $show->field('email', __('Email'));
        $show->field('profession', __('Profession'));
        $show->field('school_name', __('School name'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new UserBrainys());

        $form->text('name', __('Name'));
        $form->email('email', __('Email'));
        $form->text('profession', __('Profession'));
        $form->text('school_name', __('School name'));

        return $form;
    }

    public function seed()
    {
        $seeder = new \Database\Seeders\UserBrainysSeeder();
        $seeder->run();

        admin_success('Seeder executed successfully');

        return redirect(route('admin.user-brainys.index'));
    }
}
