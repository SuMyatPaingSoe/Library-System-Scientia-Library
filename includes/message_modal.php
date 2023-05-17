<div class="modal fade" id="MessageModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel"><?php echo $MessageTitle ?></h5>
                <button type="button" onclick="redirect()" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert <?php echo $alert ?>">
                    <?php echo $Message ?>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" onclick="redirect()" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>