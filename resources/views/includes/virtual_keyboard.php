<!-- The Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Type your text</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <div class="modal-body">
                <textarea name="ekhanelikhun" id="ekhanelikhun" onfocus=""></textarea><br>
                <input type="radio" name="layoutGrp" onclick="makeUnijoyEditor(&#39;ekhanelikhun&#39;);switched=false;" value="bvkunijoy"> Unijoy
                <input type="radio" name="layoutGrp" onclick="makePhoneticiEditor(&#39;ekhanelikhun&#39;);switched=false;" value="bvkphonetici"> Phonetic Int.
                <input type="radio" name="layoutGrp" onclick="switched=true;" value="bvkenglish" checked="">  English
            </div>

            <!-- Modal footer -->
            <div class="modal-footer">
                <button type="button" class="btn btn-danger close" data-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>

<!--Bangla keyboard embeded-->
<script language="javascript" type="text/javascript" src="<?php echo asset('plugins/bengali-virtual-keyboard/unijoy.js');?>"></script>
<script language="javascript" type="text/javascript" src="<?php echo asset('plugins/bengali-virtual-keyboard/phonetic_int.js');?>"></script>
<style>
    #ekhanelikhun {
        font-family: solaimanlipi,vrinda;
        font-size: 20px;
        width: 400px;
        height: 200px;
    }
</style>

<script>
    $(function () {
        let clicked_input;

        $('.keyboard').on('click', function (e) {
            let input_text = $(this).val();
            $('#ekhanelikhun').val(input_text);

            clicked_input = e.target;
        });

        $('.close').on('click', function () {
            let input_text = $('#ekhanelikhun').val();
            $(clicked_input).val(input_text);
        });

    });
</script>