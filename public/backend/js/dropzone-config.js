Dropzone.autoDiscover = false;

/** get url and split it */
var segments = window.location.href.split('/');
var baseUrl = window.location.protocol + "//" + window.location.hostname + (window.location.port ? ':' + window.location.port : '');
var url, id, method, type, removeLink;

if (segments[5] === 'create') {
    type = 'POST';
    url = "/services-and-works/works";
    removeLink = true;
} else if (segments[6] === 'edit') {
    type = 'PUT';
    id = segments[5];
    method = segments[6];
    url = baseUrl + "/services-and-works/works/" + id;
    removeLink = true;
} else {
    url = '/show';
    id = segments[5];
    removeLink = false;
}

$("#mydropzone").dropzone({
    url: url,
    autoProcessQueue: false,
    uploadMultiple: true,
    parallelUploads: 10,
    maxFilesize: 1, // Max file upload size constraint is 1 MB
    maxFiles: 10,
    acceptedFiles: ".jpeg,.jpg,.png,.gif",
    addRemoveLinks: removeLink,
    dictRemoveFile: 'Remove file',
    dictFileTooBig: 'Image is larger than 1MB',
    timeout: 10000,
    renameFile: function (file) {
        file.rename = new Date().getTime() + Math.floor((Math.random() * 100) + 1) + '_' + file.name;
        return file.rename;
    },
    init: function () {
        var myDropzone = this;

        /** Check for show method and disable dropzone */
        if (url === '/show') {
            myDropzone.removeEventListeners();
            getWorkPhotos(myDropzone, id);
            // console.log('show page.');
        } else {
            /** Alert for max file exceeded */
            this.on("maxfilesexceeded", function (file) {
                alert("Maximum files limit exceeded.");
                myDropzone.removeFile(file);
            });

            // form submit button
            $("#submit").click(function (e) {
                e.preventDefault();
                e.stopPropagation();
                if (myDropzone.getUploadingFiles().length === 0 && myDropzone.getQueuedFiles().length === 0) {
                    /** Form submit with no photo files selected */

                    var data;
                    if (segments[5] === 'create') {
                        data = $('#workAddForm').serializeArray();
                    } else if (segments[6] === 'edit') {
                        data = $('#workEditForm').serializeArray();
                    }

                    // console.log('data: '+ JSON.stringify(data));

                    /** retrieve heading & description from form data */
                    var heading, description;
                    $.each(data, function(key, item) {
                        if(key === 1){
                            heading = item['value'];
                        } else if(key === 2) {
                            description = item['value'];
                        }
                    });
                    
                    /** Check heading and description for null */
                    if(heading && description){
                        $.ajax({
                            type: type,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            url: url,
                            data: data,
                            dataType: 'json',
                            success: function (response) {
                                if (response.type == 'success') {
                                    console.log('success message: ' + response.message);
                                    window.location.href = "/services-and-works/works";
                                }
                            },
                            error: function(xhr) {
                                swal('Oops...', 'Something went wrong, please try again later!','error').catch(swal.noop);
                            }
                        });
                    } else {
                        swal('Oops...', 'Please fill all the required fields.' ,'error').catch(swal.noop);
                    }
                }
                else {
                    myDropzone.processQueue();
                }
            });

            this.on('sending', function (files, xhr, formData) {
                // Append all form inputs to the formData Dropzone will POST
                var data;
                if (segments[5] === 'create') {
                    data = $('#workAddForm').serializeArray();
                } else if (segments[6] === 'edit') {
                    data = $('#workEditForm').serializeArray();
                }

                $.each(data, function (key, el) {
                    formData.append(el.name, el.value);
                });
            });

            /** Call once after completion of multiple file upload */
            this.on("successmultiple", function (files, response) {
                /** Redirect to works index */
                // console.log('success message: '+response.message);
                window.location.href = "/services-and-works/works";
            });

            /** Catch error and show error message */
            this.on("errormultiple", function (file, message) {

            });

            /** For update form */
            if (method && id) {
                getWorkPhotos(myDropzone, id);
            }
            /** End */

            this.on("removedfile", function (file) {
                if (segments[6] === 'edit') {
                    $.post({
                        url: '/services-and-works/works/photo/delete',
                        data: { name: file.rename, _token: $('[name="_token"]').val() },
                        dataType: 'json',
                        success: function (response) {
                            if (response.type == 'success') {
                                // console.log('success message: ' + response.message);
                            } else {
                                // console.log('error message: ' + response.message);
                            }
                        },
                        error: function(xhr) {
                            swal('Oops...', 'Something went wrong, please try again later!','error').catch(swal.noop);
                        }
                    });
                }
            });
        }
    }
});

/** Get all work photos based on work id */
function getWorkPhotos(myDropzone, id) {
    $.getJSON('/services-and-works/works/' + id + '/photos', function (response) { // get the json response
        $.each(response.data, function (key, item) { //loop through it
            let path = base_url + "uploads/services-and-works/works/" + item.name;

            let mockFile = {
                name: item.name,
                rename: item.rename,
                size: item.size,
                accepted: true,
                kind: 'image',
                upload: {
                    filename: item.name,
                },
                dataURL: path,
            };

            myDropzone.files.push(mockFile);
            myDropzone.emit("addedfile", mockFile);
            myDropzone.createThumbnailFromUrl(
                mockFile,
                myDropzone.options.thumbnailWidth,
                myDropzone.options.thumbnailHeight,
                myDropzone.options.thumbnailMethod,
                true,
                function (thumbnail) {
                    myDropzone.emit('thumbnail', mockFile, thumbnail);
                    myDropzone.emit("complete", mockFile); // Make sure that there is no progress bar, etc...
                }
            );
            // mockFile.previewElement.addEventListener("click", function () {
            //     myDropzone.removeFile(mockFile);
            // });
        });
    });
}