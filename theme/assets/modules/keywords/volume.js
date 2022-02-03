$(document).ready(function () {
    var _searchvolumediv = $('.search_volume');
    if(_searchvolumediv !== undefined) {
        var js_app_url = $('#js_site_url').val();
        var _i = 5000;
        _searchvolumediv.each(function(){
            $('.has-loader').addClass('has-loader-active');

            var keyword = $(this).data("keyword");
            var _this = $(this);

            $.ajax({
                url: js_app_url + 'keywords/get_volumes',
                data: { keyword: keyword },
                type: 'POST',
                dataType: 'json',
                success: function(data) {
                    $(_this).find('.tb-tnx-result').html(data.total);
                    console.log(data.related.length);
                    if(data.related.length > 0) {
                        $('#suggestions').removeClass('d-none');
                        $.each(data.related, function( key, value ) {
                            var _row = `<tr class="tb-tnx-item keyword_suggestion" data-keyword="`+value.searchTerm+`">
                                            <td width="580" class="tb-tnx-id"><span>`+value.searchTerm+`</span></td>
                                            <td width="300" class="tb-tnx-result">
                                                `+value.total+`
                                            </td>
                                            <td class="tb-tnx-action">
                                                <div class="custom-control custom-control custom-switch">
                                                    <input type="checkbox" name="suggestions[]" class="custom-control-input" id="customSwitch`+_i+`" value="`+value.searchTerm+`">
                                                    <label class="custom-control-label" for="customSwitch`+_i+`"></label>
                                                </div>
                                            </td>
                                        </tr>`;
                            $('#suggestions_body').append(_row);
                            _i++;
                        });

                        $('.has-loader').removeClass('has-loader-active');
                    }
                },
                error: function() {
                    $(_this).find('.tb-tnx-result').html('Error');
                }
            });
        });
    }
});