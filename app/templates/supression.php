
<!--/**
 * Created by PhpStorm.
 * User: SBOUGH
 * Date: 13/02/2017
 * Time: 17:52
 */-->
<form action="index.php?action=supressionaction" method="post">
    <!-- Modal Dialog -->
    <!-- Dialog show event handler -->
    <script type="text/javascript">
        $('#confirmDelete').on('show.bs.modal', function (e) {
            $message = $(e.relatedTarget).attr('data-message');
            $(this).find('.modal-body p').text($message);
            $title = $(e.relatedTarget).attr('data-title');
            $(this).find('.modal-title').text($title);

            // Pass form reference to modal for submission on yes/ok
            var form = $(e.relatedTarget).closest('form');
            $(this).find('.modal-footer #confirm').data('form', form);
        });

        <!-- Form confirm (yes/ok) handler, submits form -->
        $('#confirmDelete').find('.modal-footer #confirm').on('click', function(){
            $(this).data('form').submit();
        });
    </script>
    <div class="modal fade" id="confirmDelete" role="dialog" aria-labelledby="confirmDeleteLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Confirmation de la suppression
                </div>
                <div class="modal-body">
                    <p>Etes-vous sûr de vouloir supprimer cet élément ?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirm">Delete</button>
                </div>
            </div>
        </div>
    </div>




<!--/*
$path = __dir__ . '/../data/';

$file = $_GET['id'];

unlink(__dir__ . '/../data/' . $file);
redirect('historiqueopcaim');*/
-->


