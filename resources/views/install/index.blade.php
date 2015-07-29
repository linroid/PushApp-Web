@extends('app', ['subtitle'=>"安装APP"])

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-sm-5 col-xs-12 pull-right">
                <form class="form" style="margin-top: 50px;">
                    <fieldset>
                        <legend>通过URL</legend>
                        <div class="form-group form-group-label">
                            <div class="row">
                                <div class="col-lg-6 col-sm-8">
                                    <label class="floating-label" for="float-text">URL</label>
                                    <input class="form-control" name="url" type="text">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
                                </div>
                                <div class="col-lg-5 col-sm-4">
                                    <button class="btn btn-blue waves-button waves-light waves-effect" type="submit">
                                        提交
                                    </button>
                                </div>
                            </div>
                        </div>

                    </fieldset>
                </form>
            </div>
            <div class="col-lg-6 col-sm-6 col-xs-12 pull-left">

                <div class="upload-box clearfix" id="upload">
                    <p><h2 class="text-center">拖动Apk到这里</h2></p>
                    <p>
                        <button id="fileinput-button" class="btn btn-blue waves-button waves-effect waves-light">选择文件</button>
                    </p>
                    <div class="drag-tip" style="display: none">
                        <h2><p class="text-center">拖到这里来</p></h2>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="preview-template" class="hidden" style="display: none;">
        <div class="dz-preview dz-file-preview">
            <div class="dz-progress progress progress-green">
                <div class="progress-bar" style="width: 10%" data-dz-uploadprogress></div>
            </div>
            <div class="dz-details row">
                <div class="col-lg-12 col-md-12">
                    <p class="text-center"><img class="avatar-inline avatar-lg" src="{{ asset('images/android.png') }}"/></p>
                    <div class="dz-filename text-center"><span data-dz-name></span></div>
                    <div class="dz-size text-center" data-dz-size></div>
                </div>

                <div class="dz-success-mark pull-right">
                    <div class="progress-circular progress-circular-red">
                        <div class="progress-circular-wrapper">
                            <div class="progress-circular-inner">
                                <div class="progress-circular-left">
                                    <div class="progress-circular-spinner"></div>
                                </div>
                                <div class="progress-circular-gap"></div>
                                <div class="progress-circular-right">
                                    <div class="progress-circular-spinner"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                {{--<div class="dz-error-mark text-red"><span>上传失败:(</span></div>--}}
                {{--<div class="dz-error-message text-red"><span data-dz-errormessage></span></div>--}}
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ asset('js/dropzone.js') }}"></script>
    <script type="text/javascript">
        var myDropzone = new Dropzone("#upload", {
            url: "/install/upload",
            method: "post",
            maxFilesize: 100,
            params: {
                _token: '<?php echo csrf_token(); ?>'
            },
            previewTemplate: $('#preview-template').html(),
            clickable: '#fileinput-button',
            acceptedFiles: '.apk'
        });
        myDropzone.on("success", function (file, response) {
            window.location.href = '{{url('install/target') }}?package_id='+response.id;
        });
        myDropzone.on("addedfile", function(file) {
            $('#upload').css('border', 'solid 3px #2196f3')
        });
        myDropzone.on("dragenter", function(file) {
            $('#upload').css('border', 'dashed 3px #2196f3')
        });
        myDropzone.on("dragover", function(file) {
            $('#upload').css('border', 'dashed 3px #2196f3')
        });
        myDropzone.on("dragleave", function(file) {
            $('#upload').css('border', 'dashed 3px #666666')
        });
        myDropzone.on("error", function(file, response) {
            $("body").toast({content: "上传出现错误咯:("})
        });

    </script>
@endsection