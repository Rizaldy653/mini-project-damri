<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal">
                    <span>×</span>
                </button>
            </div>

            <div class="modal-body">
                Select "Logout" below if you are ready to end your current session.
            </div>

            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <form action="<?= base_url('logout') ?>" method="post">
                    <?= csrf_field() ?>
                    <button type="submit" class="btn btn-primary">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>
