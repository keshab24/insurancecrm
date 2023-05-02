@extends('layouts.backend.containerlist')

@section('css')
    <style>
        .message .table-bordered {
            border: 1px solid black !important;
        }

    </style>
@endsection

@section('title')
    <p class="h4 align-center mb-0">Messages</p>
@endsection

@section('dynamicdata')

    <div class="box mt-3">
        <div class="box-header">
            <h2>Message details</h2>

        </div>
        <div class="box-body">
            {{-- <div class="col-3">
                <form method="POST" action="{{ route('admin.message.update', $message->id) }}">
                    @csrf
                    <div class="form-group">
                        <label for="status">Update Status</label>
                        <select class="custom-select" name="status" id="status" onchange="this.form.submit()">
                            <option value="received" @if ($message->status == 'received') selected @endif>Received</option>
                            <option value="reviewed" @if ($message->status == 'reviewed') selected @endif>Reviewed</option>
                            <option value="responded" @if ($message->status == 'responded') selected @endif>Responded</option>
                        </select>
                    </div>
                </form>
            </div> --}}
            <div class="col-6 message">

                <table class="table">
                    <tbody>
                        <tr>
                            <td>
                                <strong>Message Status:</strong>
                            </td>
                            <td>
                                {{-- <span style="text-transform: capitalize">{{ $message->status }}</span> --}}
                                <form method="POST" action="{{ route('admin.message.update', $message->id) }}">
                                    @csrf
                                    <div class="form-group">
                                        <select class="custom-select" name="status" id="status"
                                            onchange="this.form.submit()">
                                            <option value="received" @if ($message->status == 'received') selected @endif>Received</option>
                                            <option value="reviewed" @if ($message->status == 'reviewed') selected @endif>Reviewed</option>
                                            <option value="responded" @if ($message->status == 'responded') selected @endif>Responded</option>
                                        </select>
                                    </div>
                                </form>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <strong>Message Received On:</strong>
                            </td>
                            <td>
                                {{ $message->created_at->diffForHumans() }}
                            </td>
                        </tr>

                        {{-- <tr>
                            <td>
                                <strong>Last Updated On:</strong>
                            </td>
                            <td>
                                {{ $message->updated_at->diffForHumans() }}
                            </td>
                        </tr> --}}

                        <tr>
                            <td>
                                <strong>Sender's Full Name:</strong>
                            </td>
                            <td>
                                {{ $message->name }}
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <strong>Sender's Email:</strong>
                            </td>
                            <td>
                                {{ $message->email }}
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <strong>Sender's Phone Number:</strong>
                            </td>
                            <td>
                                {{ $message->phone }}
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <strong>Sender's Message:</strong>
                            </td>
                            <td>
                                {{ $message->message }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
@endsection
