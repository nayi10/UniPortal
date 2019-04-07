<?php include("header.php");?>
<div class="modal fade" id="popup" tabindex="-1" role="dialog" aria-labelledby="newModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="newModal">Ask a new question</h5>
                <div class="alert hide mt-3"></div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="questionForm">
                <div class="modal-body">
                    <label for="question">Question</label>
                    <input type="text" name="question" id="question" class="form-control">
                    <div id="matched-list" class="hide"></div><hr>
                    <label for="desc">Add a description</label>
                    <div id="description"></div>
                    <div class="input-group">
                        <label for="tags">Add tags</label>
                        <input type="text" class="form-control" id="tags" name="tags">
                        <input type="hidden" name='username' id="username" value="$username">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" id="btnAdd" class="btn btn-primary">Ask question</button>
                </div>
            </form>
        </div>
    </div>
</div>