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
                        <option>Number</option> 
                        <option>Telephone</option> 
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

    function add_field(type, value, name_key) {
        var input = $("<input></input>");
        input.attr("type", type);
        input.attr("placeholder", value);
        input.attr("name", name_key);
        return input;
    }
    window.addEventListener('load', function() {
        var container = $("#fields");
        var li = $("<li></li>");
        $("#add").click(function() {
            var name = add_field("text", "name", "names");
            name.appendTo( li );
            var placeholder = add_field("text", "placeholder", "placeholders");
            placeholder.appendTo( li );
            //create type
            var type = $("<select></select>");
            type.attr("name", "types[]");
            var opts = [
                'Number',
                'Telephone'
            ];
            opts.forEach(function( opt ) {
                var el = $("<option></option>");
                el.val( opt );
                el.appendTo( types );
            });
            
            li.appendTo(container);
        });
    })

</script>