<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use App\Models\UserMaterial;
use Illuminate\Database\Seeder;
use DB;

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
        return new Grid(new UserMaterial(), function (Grid $grid) {
            $grid->column('id', __('Id'));
            $grid->column('user_name', __('User Name'));
            $grid->column('user_id', __('Generate Count'));

            $grid->tools(function (Grid\Tools $tools) {
                $tools->append('<a href="' . route('admin.user-materials.seed') . '" class="btn btn-sm btn-success">Refresh Data</a>');
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
        $show = new Show(UserMaterial::findOrFail($id));

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
        $form = new Form(new UserMaterial());

        $form->text('user_name', __('User Name'));
        $form->number('user_id', __('Generate Count'));

        return $form;
    }

    public function seed()
    {
        // Seeding dengan mengambil method pada UserMaterialSeeder.php
        $seeder = new \Database\Seeders\UserMaterialSeeder();
        $seeder->run();

        admin_success('Seeder executed successfully');

        return redirect(route('admin.user-materials.index'));
    }
}
