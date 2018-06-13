# Bootstrap Image Upload

`bootstrap-imgupload` is a Bootstrap/jQuery plugin which shows a preview of the image to be uploaded from both file and URL.

## Demo

http://egonolieux.github.io/bootstrap-imgupload

## Requirements

- Bootstrap 3.0.0+
- jQuery 1.6.1+

## Installation

Include the script *after* jQuery and Bootstrap:

<script type="text/javascript" src="js/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="js/bootstrap.min.js"></script>
<script type="text/javascript" src="js/bootstrap-imgupload.min.js"></script>

## Usage

### HTML

Use as many instances on the same page as you want.

```HTML
<div class="imgupload panel panel-default">
    <div class="panel-heading clearfix">
        <h3 class="panel-title pull-left">Upload image</h3>
        <div class="btn-group pull-right">
            <button type="button" class="btn btn-default active">File</button>
            <button type="button" class="btn btn-default">URL</button>
        </div>
    </div>
    <div class="file-tab panel-body">
        <div>
            <button type="button" class="btn btn-default btn-file">
                <span>Browse</span>
                 <!-- The file is stored here. -->
                <input type="file" name="file-input">
            </button>
            <button type="button" class="btn btn-default">Remove</button>
        </div>
    </div>
    <div class="url-tab panel-body">
        <div class="input-group">
            <input type="text" class="form-control" placeholder="Image URL">
            <div class="input-group-btn">
                <button type="button" class="btn btn-default">Submit</button>
            </div>
        </div>
        <!-- The URL is stored here. -->
        <input type="hidden" name="url-input">
    </div>
</div>
```

### jQuery

#### Using Default Options

```jQuery
$('imgupload').imgupload();
```

Default options are:

```jQuery
allowedFormats: [ "jpg", "jpeg", "png", "gif" ],
previewWidth: 250,
previewHeight: 250,
maxFileSizeKb: 2048
```

#### Overriding Default Options

```jQuery
$('imgupload').imgupload({
    allowedFormats: [ "jpg" ],
    maxFileSizeKb: 512
});

```
