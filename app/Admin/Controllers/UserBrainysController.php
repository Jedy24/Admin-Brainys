<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use App\Models\UserBrainys;
use Illuminate\Database\Seeder;
use DB;
use Illuminate\Support\Facades\Http;

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
            $grid->column('id', __('Id'))->sortable();
            $grid->column('name', __('Name'));
            $grid->column('email', __('Email'));
            $grid->column('profession', __('Profession'));
            $grid->column('school_name', __('School name'));

            $grid->tools(function (Grid\Tools $tools) {
                $tools->append('<a href="' . route('admin.user-brainys.seed') . '" class="btn btn-sm btn-success">Refresh Data</a>');
            });

            $grid->column('actions', __('Actions'))->display(function () {
                return '<a href="' . route('admin.user-brainys.forgot-password', ['user_id' => $this->id]) . '" class="btn btn-sm btn-success">Reset Password</a>';
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
        // Seeding dengan mengambil method pada UserBrainysSeeder.php
        $seeder = new \Database\Seeders\UserBrainysSeeder();
        $seeder->run();

        admin_success('Seeder executed successfully');

        return redirect(route('admin.user-brainys.index'));
    }

    public function forgotPassword($user_id)
    {
        try {
            // Consume API
            $apiUrl = 'https://be.brainys.oasys.id/api/forgot-password';

            // Mendapatkan email user
            $userEmail = UserBrainys::find($user_id)->email;

            // Memanggil API dengan data email user yang akan dikirim mail notificationnya
            $response = Http::post($apiUrl, [
                'email' => $userEmail,
            ]);

            // Handle response dari API
            $responseData = $response->json();

            if ($response->successful() && $responseData['status'] === 'success') {
                // Menampilkan konfirmasi menggunakan JavaScript dengan menyertakan email
                echo '<script>';
                echo 'var confirmed = confirm("Reset password email berhasil dikirim ke ' . $userEmail . '.");';
                echo 'if (confirmed) { window.location.href = "' . route('admin.user-brainys.index') . '"; }';
                echo '</script>';
            } else {
                // Menampilkan pesan error menggunakan JavaScript
                echo '<script>';
                echo 'alert("Failed to reset password email");';
                echo '</script>';
            }
        } catch (\Exception $e) {
            // Menampilkan pesan error menggunakan JavaScript
            echo '<script>';
            echo 'alert("Error: ' . $e->getMessage() . '");';
            echo '</script>';
        }
    }
}
