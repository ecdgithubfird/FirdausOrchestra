<div class="row mb-3">
    <div class="col-12 col-sm-4">
        <div class="form-group">
            <?php
            $field_name = 'name';
            $field_lable = label_case($field_name);
            $field_placeholder = $field_lable;
            $required = "required";
            ?>
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
    <div class="col-12 col-sm-4">
        <div class="form-group">
            <?php
            $field_name = 'slug';
            $field_lable = label_case($field_name);
            $field_placeholder = $field_lable;
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
    <div class="col-12 col-sm-4">
        <div class="form-group">
            <?php
            $field_name = 'group_name';
            $field_lable = label_case($field_name);
            $field_placeholder = $field_lable;
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>     
</div>
<div class="row mb-3">
    <div class="col-12 col-sm-4">    
        <div class="form-group">
            <?php
            $field_name = 'parent_category';
            $field_lable = label_case($field_name);
            $field_placeholder = "-- Select an option --";           
            $categories = DB::table('categories')->get();
            $select_options = [];
            foreach ($categories as $i) {
                $select_options[$i->id] = $i->name;
            }
            ?>
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-select')->attributes(["$required"]) }}
        </div>
    </div> 
    <div class="col-12 col-sm-4">    
        <?php
            $field_name = 'category_order';
            $field_lable = label_case($field_name);
            $field_placeholder = "-- Select an option --";  
            $required = "";
        ?>
        {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
        {{ html()->select($field_name)->id('category_order')->placeholder($field_placeholder)->class('form-control select2')->attributes(["$required"]) }}
    </div>  
</div>
<div class="row mb-3">
    <div class="col-8">
        <div class="form-group">
            <?php
            $field_name = 'image';
            $field_lable = label_case($field_name);
            $field_placeholder = $field_lable;
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            {{ html()->input("file", $field_name)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>

    @if($data && $data->getMedia($module_name)->first())
    <div class="col-4">
        <div class="float-end">
            <figure class="figure">
                <a href="{{ asset($data->$field_name) }}" data-lightbox="image-set" data-title="Path: {{ asset($data->$field_name) }}">
                    <img src="{{ asset($data->getMedia($module_name)->first()->getUrl('thumb300')) }}" class="figure-img img-fluid rounded img-thumbnail" alt="">
                </a>
                <!-- <figcaption class="figure-caption">Path: </figcaption> -->
            </figure>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="image_remove" id="image_remove" name="image_remove">
                <label class="form-check-label" for="image_remove">
                    Remove this image
                </label>
            </div>
        </div>
    </div>
    <x-library.lightbox />
    @endif
</div>
<div class="row mb-3">
    <div class="col-12">
        <div class="form-group">
            <?php
            $field_name = 'description';
            $field_lable = label_case($field_name);
            $field_placeholder = $field_lable;
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            {{ html()->textarea($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
</div>
<hr>
<div class="row mb-3">
    <div class="col-12 col-sm-4">
        <div class="form-group">
            <?php
            $field_name = 'meta_title';
            $field_lable = label_case($field_name);
            $field_placeholder = $field_lable;
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
    <div class="col-12 col-sm-4">
        <div class="form-group">
            <?php
            $field_name = 'meta_keyword';
            $field_lable = label_case($field_name);
            $field_placeholder = $field_lable;
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
    <div class="col-12 col-sm-4">
        <div class="form-group">
            <?php
            $field_name = 'meta_description';
            $field_lable = label_case($field_name);
            $field_placeholder = $field_lable;
            $required = "";
            ?>
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            {{ html()->text($field_name)->placeholder($field_placeholder)->class('form-control')->attributes(["$required"]) }}
        </div>
    </div>
</div>

<div class="row mb-3">
    <div class="col-12 col-sm-4">
        <div class="form-group">
            <?php
            $field_name = 'status';
            $field_lable = label_case($field_name);
            $field_placeholder = "-- Select an option --";
            $required = "required";
            $select_options = [
                'Active' => 'Active',
                'Inactive' => 'Inactive',
                'Draft' => 'Draft'
            ];
            ?>
            {{ html()->label($field_lable, $field_name)->class('form-label') }} {!! fielf_required($required) !!}
            {{ html()->select($field_name, $select_options)->placeholder($field_placeholder)->class('form-select')->attributes(["$required"]) }}
        </div>
    </div>
</div>

<!-- Select2 Library -->
<x-library.select2 />

@push('after-styles')
<!-- File Manager -->
<link rel="stylesheet" href="{{ asset('vendor/file-manager/css/file-manager.css') }}">

<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">
<style>
    .note-editor.note-frame :after {
        display: none;
    }

    .note-editor .note-toolbar .note-dropdown-menu,
    .note-popover .popover-content .note-dropdown-menu {
        min-width: 180px;
    }
</style>
@endpush

@push ('after-scripts')
<script type="module" src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>
<script type="module">
    // Define function to open filemanager window
    var lfm = function(options, cb) {
        var route_prefix = (options && options.prefix) ? options.prefix : '/laravel-filemanager';
        window.open(route_prefix + '?type=' + options.type || 'file', 'FileManager', 'width=900,height=600');
        window.SetUrl = cb;
    };

    // Define LFM summernote button
    var LFMButton = function(context) {
        var ui = $.summernote.ui;
        var button = ui.button({
            contents: '<i class="note-icon-picture"></i> ',
            tooltip: 'Insert image with filemanager',
            click: function() {

                lfm({
                    type: 'image',
                    prefix: '/laravel-filemanager'
                }, function(lfmItems, path) {
                    lfmItems.forEach(function(lfmItem) {
                        context.invoke('insertImage', lfmItem.url);
                    });
                });

            }
        });
        return button.render();
    };

    $('#content').summernote({
        height: 120,
        toolbar: [
            ['style', ['style']],
            ['font', ['fontname', 'fontsize', 'bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'lfm', 'video']],
            ['view', ['codeview', 'undo', 'redo', 'help']],
        ],
        buttons: {
            lfm: LFMButton
        }
    });
</script>

<script type="module" src="{{ asset('vendor/laravel-filemanager/js/stand-alone-button.js') }}"></script>
<script type="module">
    $('#button-image').filemanager('image');
</script>

<script type="module">
    $(document).ready(function() {
        var groupName = $("#group_name").val();
        if(groupName){
            setCategoryOrder(groupName,1);       
         }
        
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
            document.querySelector('.select2-container--open .select2-search__field').focus();
        });

        $('.select2-category').select2({
            theme: "bootstrap4",
            placeholder: '@lang("Select an option")',
            minimumInputLength: 2,
            allowClear: true,
            ajax: {
                url: '{{route("backend.categories.index_list")}}',
                dataType: 'json',
                data: function(params) {
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });

        $('.select2-tags').select2({
            // theme: "bootstrap4",
            placeholder: '@lang("Select an option")',
            minimumInputLength: 2,
            allowClear: true,
            ajax: {
                url: '{{route("backend.tags.index_list")}}',
                dataType: 'json',
                data: function(params) {
                    return {
                        q: $.trim(params.term)
                    };
                },
                processResults: function(data) {
                    return {
                        results: data
                    };
                },
                cache: true
            }
        });
        $('#group_name').on('change', function () {  
            var catName = $("#group_name").val(); 
            setCategoryOrder(catName,0);
            
        });

        function setCategoryOrder(groupName,actionValue){            
            $.ajax({
                url: '{{ route("backend.categories.catCount") }}',
                method: 'POST',
                data: { groupName: groupName, _token: '{{ csrf_token() }}' },
                success: function(response) {   
                    console.log(response);                            
                    updateCatOrderValues(response,actionValue);
                },
                error: function(error) {
                    console.error('Error fetching menu order:', error);
                    if (error.responseText) {
                        console.log('Response text:', error.responseText);
                    }
                }
            });
        }
        function updateCatOrderValues(catOrder,actionValue) {
                var $catDropdown = $('#category_order');     
                if (actionValue == 1){
                    var catOrder = catOrder;
                }
                else{
                    var catOrder = catOrder + 1;
                }           
                $catDropdown.empty();
                $catDropdown.append('<option value="">' + '{{ __("Select an option") }}' + '</option>');

                // Append options ranging from 1 to menuOrder + 1
                for (var i = 1; i <= catOrder; i++) {
                    $catDropdown.append('<option value="' + i + '">' + i + '</option>');
                }
            }

    });
</script>
@endpush