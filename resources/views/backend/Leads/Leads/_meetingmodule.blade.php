<div id="meetingModal" class="modal left fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header remarks-add-header">
                    <h4 class="modal-title">Add Meetings</h4>
                <button type="button" class="close align-self-center" data-dismiss="modal"><img src="{{ asset('uploads/Dismiss-Circle-Regular-24.svg') }}" alt="Menu-collapse"></button>
                </div>
                <div class="modal-body container">
                    <div id="listmeetings">
                    </div>
                    <form class="form-horizontal pt-4" role="form" method="POST" action="{{route('admin.leads.meetings')}}" >
                        {{ csrf_field() }}
                        <input type="hidden" name="lead_id" id="lead_id" value="">
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label for="Content">Topic</label>
                                    <textarea name="title" id="remark" class="form-control" rows="4" required></textarea>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="form-group">
                                    <label class="control-label" for="type">Meeting Date:</label>
                                    <input type="datetime-local" class="form-control" id="remark_date" name="start" required>

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer remarks-modal-footer">
                            <button type="button" class="btn btn-outline-secondary c-btn-style c-ghost-btn" data-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-primary c-btn-style add c-primary-btn">
                                Add
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
