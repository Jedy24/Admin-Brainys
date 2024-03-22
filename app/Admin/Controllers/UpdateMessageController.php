<?php

namespace App\Admin\Controllers;

use OpenAdmin\Admin\Controllers\AdminController;
use OpenAdmin\Admin\Form;
use OpenAdmin\Admin\Grid;
use OpenAdmin\Admin\Show;
use \App\Models\UpdateMessage;

use Illuminate\Support\Facades\Http;

class UpdateMessageController extends AdminController
{
    /**
     * Title for current resource.
     *
     * @var string
     */
    protected $title = 'UpdateMessage';

    /**
     * Make a grid builder.
     *
     * @return Grid
     */
    protected function grid()
    {
        return new Grid(new UpdateMessage(), function (Grid $grid) {
            $grid->column('id', __('Id'));
            $grid->column('version', __('Version'));
            $grid->column('message', __('Message'));
			$grid->column('created_at', __('Created at'));
			$grid->column('updated_at', __('Updated at'));

			$grid->tools(function (Grid\Tools $tools) {
				$tools->append('<a href="' . route('admin.update-messages.send-updates') . '" class="btn btn-sm btn-success">Send Updates</a>');
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
        $show = new Show(UpdateMessage::findOrFail($id));

        $show->field('id', __('Id'));
        $show->field('version', __('Version'));
        $show->field('message', __('Message'));
        $show->field('created_at', __('Created at'));
        $show->field('updated_at', __('Updated at'));

        return $show;
    }

    /**
     * Make a form builder.
     *
     * @return Form
     */
    protected function form()
    {
        $form = new Form(new UpdateMessage());

        $form->text('version', __('Version'));
        $form->textarea('message', __('Message'));

        return $form;
    }

	public function sendUpdates()
    {
        try {
            // Make a request to the API
            $response = Http::get('https://be.brainys.oasys.id/api/check-updates');

            // Get the response body
            $responseData = $response->json();

            // Check if the request was successful and the status is 'success'
            if ($response->successful() && $responseData['status'] === 'success') {
                // Menampilkan konfirmasi menggunakan JavaScript
                echo '<script>';
                echo 'var confirmed = confirm("Data berhasil dikirim ke back-end Brainys!");';
                echo 'if (confirmed) { window.location.href = "' . route('admin.update-messages.index') . '"; }';
                echo '</script>';
            } else {
                // Menampilkan pesan error menggunakan JavaScript
                echo '<script>';
                echo 'alert("Gagal mengirim data!");';
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
