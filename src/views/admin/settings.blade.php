@extends('photon::layouts.settings')

{{-- Title --}}
@section('title')
<title>{{ Config::get('photon::photon.title') }} - Settings</title>
@stop

@section('menuTitle')
Settings
@stop

{{-- Content --}}
@section('content')
<div class="container-fluid admin-settings" id="module-settings">
    <div class="form-legend">General Module Settings</div>
    <!--Module ID from the module table-->
    <input type="hidden" @if($moduleId) name="module[id]" @endif id="module_id" value="{{$moduleId}}" />
    <div class="control-group row-fluid">
        <div class="span2">
            <label class="control-label" for="name">
                Module Name
                <a href="javascript:;" class="bootstrap-tooltip" tabIndex="-1" data-placement="top"
                   data-original-title="Module name as it will appear in admin panel menu, as module page title etc."><i
                        class="icon-photon info-circle"></i></a>
            </label>
        </div>
        <div class="span4">
            <div class="controls">
                <input required autofocus id="name" type="text" name="module[name]"
                @if($module)value="{{$module->name}}"@endif/>
            </div>
        </div>
        <div class="span2">
            <label class="control-label" for="table_name">
                Table Name
                <a href="javascript:;"
                   class="bootstrap-tooltip"
                   tabIndex="-1"
                   data-placement="top"
                   data-original-title="Auto-generated MYSQL table name that can be changed by typing in a new value.">
                    <i class="icon-photon info-circle"></i>
                </a>
            </label>
        </div>
        <div class="span4">
            <div class="controls">
                <input required
                       id="table_name"
                       type="text"
                       name="module[table_name]"
                       data-bound="<?= $module ? 0 : 1 ?>"
                    <?= $module ? "readonly value='{$module->table_name}'" : '' ?>
                    />
            </div>
        </div>
    </div>
    <div class="control-group row-fluid">
        <div class="span2">
            <label class="control-label" for="parent_module">
                Folder
                <a href="javascript:;"
                   class="bootstrap-tooltip"
                   tabIndex="-1"
                   data-placement="top"
                   data-original-title="If selected, current module will be nestable under selected parent module's items.">
                    <i class="icon-photon info-circle"></i>
                </a>
            </label>
        </div>
        <div class="span4">
            <div class="controls">
                <select name="module[folder_id]" id="folder_id">
                    <option value="">None</option>
                    <?php foreach ($folders as $folder): ?>
                        <option value="<?= $folder->id ?>"
                            <?= $module->folder_id == $folder->id ? 'selected' : '' ?>
                            >
                            <?= $folder->name ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="span2">
            <label class="control-label" for="nestable">
                <input
                    type="checkbox"
                    <?= $module->nestable ? 'checked' : '' ?>
                    name="module[nestable]"
                    id="nestable"
                    class="uniformCheckbox"
                    value="<?= $module->nestable ?>">
                <input type="hidden" name="module[nestable]" value="<?= $module->nestable ?>"/>
                Nestable
                <a href="javascript:;"
                   class="bootstrap-tooltip"
                   tabIndex="-1"
                   data-placement="top"
                   data-original-title="If nesting is allowed this module's items will be
                   nestable under each other (e.g. to create a category tree).">
                    <i class="icon-photon info-circle"></i>
                </a>
            </label>
        </div>
    </div>
</div>
<div id="module-fields">@if($fieldsJson)<img
        src="{{ Config::get('photon::photon.package_assets_uri') }}/images/photon/preloader/2.gif" class="loader"
        alt="loader">@endif
</div>
<style>
    #module_field_template {
        display: none;
    }
</style>
<div id="module_field_template">
    <!-- Module Field Template begins -->
    <div class="container-fluid admin-settings module-field" data-field-id="--autogenerate">
        <div class="form-legend">
            <span id="field-title" class="muted">Empty Field</span>
            <a href="javascript:;" class="remove-field" tabIndex="-1">
                <i class="icon-minus-sign"></i>
            </a>
        </div>
        <input type="hidden" class="module-field-input" data-input-name="id" name="--autogen" value=""/>

        <div class="control-group row-fluid">
            <div class="span2">
                <label class="control-label" for="--autogenerate-name">
                    Field Name
                    <a href="javascript:;" class="bootstrap-tooltip" tabIndex="-1" data-placement="top"
                       data-original-title="Field name as it will appear in module form page."><i
                            class="icon-photon info-circle"></i></a>
                </label>
            </div>
            <div class="span2">
                <div class="controls">
                    <input required type="text" class="module-field-input" data-input-name="name" name="--autogen"/>
                </div>
            </div>
            <div class="span2">
                <label class="control-label" for="field_type">
                    Field Type
                    <a href="javascript:;" class="bootstrap-tooltip" tabIndex="-1" data-placement="top"
                       data-original-title="Module form field type."><i class="icon-photon info-circle"></i></a>
                </label>
            </div>
            <div class="span2">
                <div class="controls">
                    <select class="module-field-input" data-input-name="type" name="--autogen">
                        @foreach(\Config::get('photon::settings.fieldTypes') as $field_type)
                        <option value="{{$field_type[0]}}" data-column-type="{{$field_type[1]}}">
                            {{ucwords(str_replace('-', ' ', $field_type[0]))}}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="span2">
                <label class="control-label" for="relation_table">
                    Rel. Table
                    <a href="javascript:;" class="bootstrap-tooltip" tabIndex="-1" data-placement="top"
                       data-original-title="Relationship table (used only for 'One To One' and 'One To Many' Field Type options.)."><i
                            class="icon-photon info-circle"></i></a>
                </label>
            </div>
            <div class="span2">
                <div class="controls">
                    <select class="module-field-input" data-input-name="relation_table" name="--autogen">
                    </select>
                </div>
            </div>
        </div>
        <div class="control-group row-fluid">
            <div class="span2">
                <label class="control-label" for="column_name">
                    Column Name
                    <a href="javascript:;" class="bootstrap-tooltip" tabIndex="-1" data-placement="top"
                       data-original-title="Auto-generated MYSQL column name that can be changed by typing in a new value."><i
                            class="icon-photon info-circle"></i></a>
                </label>
            </div>
            <div class="span2">
                <div class="controls">
                    <input type="text" class="module-field-input" data-input-name="column_name" data-bound="1"
                           name="--autogen"/>
                </div>
            </div>
            <div class="span2">
                <label class="control-label" for="column_type">
                    Column Type
                    <a href="javascript:;" class="bootstrap-tooltip" tabIndex="-1" data-placement="top"
                       data-original-title="MYSQL column type."><i class="icon-photon info-circle"></i></a>
                </label>
            </div>
            <div class="span2">
                <div class="controls">
                    <select class="module-field-input" data-input-name="column_type" name="--autogen">
                        @foreach(\Config::get('photon::settings.columnTypes') as $column_type)
                        <option value="{{$column_type}}">{{$column_type}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="span2">
                <label class="control-label" for="tooltip_text">
                    Tooltip Text
                    <a href="javascript:;" class="bootstrap-tooltip" tabIndex="-1" data-placement="top"
                       data-original-title="Optional tooltip info text that would be displayed next to Field Name just like this tooltip info."><i
                            class="icon-photon info-circle"></i></a>
                </label>
            </div>
            <div class="span2">
                <div class="controls">
                    <input class="module-field-input" data-input-name="tooltip_text" name="--autogen" type="text"/>
                </div>
            </div>
        </div>
    </div>
    <!-- Module Field Template ends -->
</div>

@stop

@section('form-controls')
<div class="container-fluid" id="form-controls">
    <!-- Form Controls begin -->
    <div class="control-group form-control row-fluid">
        <div class="span12">
            <div class="controls">
                <label class="radio" style="display: inline-block;">
                    <input checked="checked" type="checkbox" name="run_migrations" class="uniformCheckbox" value="1">
                    Automatically run database migrations
                    <a href="javascript:;" class="bootstrap-tooltip" tabIndex="-1" data-placement="top"
                       data-original-title="If not checked you will need to run migrations ('php artisan migrate') from the command line to update the database with current changes."><i
                            class="icon-photon info-circle"></i></a>
                </label>
                <button type="button" class="btn" id="add-new-field">Add New Field</button>
                <!--<button type="button" class="btn btn-primary" id="validate_form">Validate</button>-->
                <button type="button" class="btn btn-primary" id="validate_form">Save Module Settings</button>
                @if($moduleId)
                <button type="button" class="btn btn-danger form-control-reset">Remove Module</button>
                @endif
                <span class="confirm-reset-wrapper">
                    <span class="sure">Are you sure?</span>
                    <button type="button" class="btn btn-danger" id="remove_module">Yes</button>
                    <button type="button" class="btn form-control-cancel">No</button>
                </span>
            </div>
        </div>
    </div>
    <!-- Form Controls end -->
</div>
@stop

{{-- Javascript --}}
@section('javascript')
<script>
    var fieldsJson = {};
    <?php if($fieldsJson):?>
    fieldsJson = <?=$fieldsJson?>;
    <?php endif; ?>
</script>
<script type="text/javascript"
        src="{{ Config::get('photon::photon.package_assets_uri') }}/js/admin-settings.js"></script>
<script type="text/javascript"
        src="{{ Config::get('photon::photon.package_assets_uri') }}/js/string-extension.js"></script>
<script>
    $(document).ready(function() {

        // Initialise checkboxes
        $(".uniformCheckbox").uniform();
        // Set selected node based on URL fragment
        var selectedNode = 'module_' + $.url().segment(3);
        // Initialise jsTree
        $("#jstree").jstree({

            "json_data": {

                "ajax": {
                    // the URL to fetch the data
                    "url" : "<?=\Request::root()?>/admin/jstree-settings",
                    // the `data` function is executed in the instance's scope
                    // the parameter is the node being loaded
                    // (may be -1, 0, or undefined when loading the root nodes)
                    "data": function(n) {
                        // the result is fed to the AJAX request `data` option
                        return {
                            "id": n.attr ? n.attr("id").replace(n.attr("data-module-name") + "_", "") : null
                        };
                    }
                }

            },
            "plugins"  : [
                "themes",
                "json_data",
                "ui",
                "themes",
                "dnd",
                "crrm",
                "types"
            ],
            "ui"       : {
                "initially_select": selectedNode
            },
            "core"     : {
                <?php if(isset($moduleId) && is_numeric($moduleId)): ?>
                "initially_open": ["module_<?=$moduleId?>"]
                <?php endif;?>
            },
            "themes"   : {
                "theme": "photonui",
                "url"  : "{{ Config::get('photon::photon.package_assets_uri') }}/js/plugins/jstree/themes/photonui/style.css"
            },
            "crrm"     : {
                "move": {
                    "default_position": "first",
                    "check_move"      : function(m) {
                        // m.np new parent
                        // m.o the node being moved
                        // $(m.np[0]).attr('rel') holds the node type name
                        // field nodes can be moved only inside it's parents
                        if ($(m.o[0]).attr('data-module-name') == 'field') {
                            return ($(m.o[0]).attr('data-parent-id') == $(m.np[0]).attr('id')) ? true : false;
                        }
                        // module nodes can be moved only inside root
                        if ($(m.o[0]).attr('data-module-name') == 'module') {
                            return ($(m.np[0]).attr('id') == 'jstree') ? true : false;
                        }
                        return false;
                    }
                }
            },
            "types"    : {
                "types": {
                    "default": {
                        "select_node": function(item) {
                            window.location = $(item).find('a').attr('href');
                            return true;
                        }
                    },
                    "file"   : {
                        "select_node": function() {
                            return false;
                        }
                    }
                }
            }
        }).bind("move_node.jstree", function(e, data) {
                var node_name = $(data.rslt.o[0]).attr('data-module-name');
                var id = $(data.rslt.o[0]).attr('id').replace(node_name + '_', '');
                var parent_node_name = $(data.rslt.o[0].parentNode.parentNode).attr('data-module-name');
                var parent_node_id = $(data.rslt.o[0].parentNode.parentNode).attr('id').replace(parent_node_name + '_',
                    '');
                var next_sibling = $(data.rslt.o[0].nextSibling).attr('id');
                var previous_sibling = $(data.rslt.o[0].previousSibling).attr('id');
                $.ajax({
                    async: false,
                    type : 'POST',
                    url  : '<?=\Request::root()?>/admin/jstree-settings',
                    data : {
                        "id"              : id,
                        "node_name"       : node_name,
                        "parent_node_id"  : parent_node_id,
                        "parent_node_name": parent_node_name,
                        "next_sibling"    : next_sibling ? next_sibling.replace(node_name + '_', '') : '',
                        "previous_sibling": previous_sibling ? previous_sibling.replace(node_name + '_', '') : ''
                    }
                });
            });
    });
</script>
@stop
