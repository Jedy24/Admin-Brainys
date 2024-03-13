<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\UserExercise;

class UserExerciseController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'UserExercise';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return new Grid(new UserExercise(), function (Grid $grid) {
            $grid->column('id', __('Id'));
            $grid->column('user_name', __('User Name'));
            $grid->column('user_id', __('Generate Count'));

            $grid->tools(function (Grid\Tools $tools) {
                $tools->append('<a href="' . route('admin.user-exercises.seed') . '" class="btn btn-sm btn-success">Refresh Data</a>');
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
        $show = new Show(UserExercise::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('user_name', __('User Name'));
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
        $form = new Form(new UserExercise());

        $form->text('user_name', __('User Name'));
        $form->text('user_id', __('Generate Count'));

        return $form;
    }

    public function seed()
    {
        // Seeding dengan mengambil method pada UserExerciseSeeder.php
        $seeder = new \Database\Seeders\UserExerciseSeeder();
        $seeder->run();

        admin_success('Seeder executed successfully');

        return redirect(route('admin.user-exercises.index'));
    }
}
