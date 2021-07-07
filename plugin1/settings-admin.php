<?php 

esc_html_e( 'RCP User fields', 'textdomain' ); 
$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}rcp_customfields", ARRAY );
?>

<form method="POST">
    <h5>Fields</h5>
    <ul id="fields">
        <?php foreach ( $results as $result ): ?>
            <li class="row">
                <div class="col-md-9">
                    <label><?=$result['name']?></label>
                    <input type="text" placeholder="Name" name="names[]" id="rcp_<?=$result['id']?>_name" value="<?php echo esc_attr( $result['name'] ); ?>"/>
                    <input type="text" placeholder="placeholder" names="placeholders[]" id="rcp_<?=$result['id']?>_placeholder" value="<?php echo esc_attr( $result['placeholder'] ); ?>"/>
                    <select name="types[]">
                        <option>Text</option> 
                        <option>Dropdown</option> 
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="button" class="remove-btn" data-id="">[X]</button>
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
    <button id="add">Add field</button>
    <hr/>
    <button type="submit">Submit</button>
</form>
<script>

        var stored_fields = [];
    function add_field(type, value, name_key) {

        if ( type === 'text' ) {
            var input = $("<input></input>");
            input.attr("type", type);
            input.attr("placeholder", value);
            input.attr("name", name_key);
            return input;
        } else if ( type === 'dropdown' ) {
            var cont = $("<div></div>");
            var input = $("<input></input>");
            input.attr("type", type);
            input.attr("placeholder", value);
            input.attr("name", name_key);
            input.appendTo( cont );
            var info = $("<small>Separate multiple values by commas. For example: apples, oranges, grapes");
            info.appendTo( cont );
            return cont;
        }
    }
    function add_field(stored_info) {
            var name = add_field("text", "name", "names");
            if ( stored_info ) {
                name.val( stored_info.name );
            }
            name.appendTo( li );
            var placeholder = add_field("text", "placeholder", "placeholders");
            placeholder.appendTo( li );
            //create type
            var type = $("<select></select>");
            type.attr("name", "types[]");
            var opts = [
                'Text',
                'Dropdown'
            ];
            opts.forEach(function( opt ) {
                var el = $("<option></option>");
                el.val( opt );
                el.appendTo( types );
            });
            if ( stored_info ) {
                type.val( stored_info.type );
            }
            
            li.appendTo(container);
    }
    window.addEventListener('load', function() {
        var container = $("#fields");
        var li = $("<li></li>");
        $("#add").click(function() {
            add_field();
        });
        stored_fields.forEach(function( field ) {
            add_field( field );
        });
    })

</script>