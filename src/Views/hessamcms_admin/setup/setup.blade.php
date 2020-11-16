<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8" />
	<link rel="apple-touch-icon" sizes="76x76" href="assets/img/apple-icon.png">
	<link rel="icon" type="image/png" href="assets/img/favicon.png">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Hessam CMS pacakge setup</title>

	<meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />

	<!--     Fonts and icons     -->
	<link href="http://netdna.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.css" rel="stylesheet">

	<!-- CSS Files -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="{{ asset('admin-setup.css') }}" rel="stylesheet">
</head>

<body>
<div style="background-color: #e2e8f0">

    <div class="container">
        <div class="row">
        <div class="col-sm-8 col-sm-offset-2">

            <div class="wizard-container">
                <div class="card wizard-card" data-color="green" id="wizard">
                <form action="{{route("hessamcms.admin.languages.setup_submit")}}" method="post">
                    @csrf

                    	<div class="wizard-header" style="text-align: center">
{{--                        	<img src="assets/img/hessam-cms.png" style="padding: 10px 10px 20px 10px;">--}}
                    	</div>
						<div class="wizard-navigation">
							<ul>
	                            <li><a href="#language" data-toggle="tab">Language</a></li>
	                        </ul>
						</div>

                        <div class="tab-content">
                            <div class="tab-pane" id="language">
                              <div class="row">
                                  <div class="col-sm-12">
                                    <h4 class="info-text">Your default language is English in Beta release. Add more language from admin panel.</h4>
                                  </div>
                                  <div class="col-sm-12">
                                       <div class="form-group">
                                            <label>Language</label><br>
                                           <select readonly class="form-control" id="lang-name" data-placeholder="Choose a Language...">
{{--                                               <option value="AF">Afrikaans</option>--}}
{{--                                               <option value="SQ">Albanian</option>--}}
{{--                                               <option value="AR">Arabic</option>--}}
{{--                                               <option value="HY">Armenian</option>--}}
{{--                                               <option value="EU">Basque</option>--}}
{{--                                               <option value="BN">Bengali</option>--}}
{{--                                               <option value="BG">Bulgarian</option>--}}
{{--                                               <option value="CA">Catalan</option>--}}
{{--                                               <option value="KM">Cambodian</option>--}}
{{--                                               <option value="ZH">Chinese (Mandarin)</option>--}}
{{--                                               <option value="HR">Croatian</option>--}}
{{--                                               <option value="CS">Czech</option>--}}
{{--                                               <option value="DA">Danish</option>--}}
{{--                                               <option value="NL">Dutch</option>--}}
{{--                                               <option value="EN">English</option>--}}
{{--                                               <option value="ET">Estonian</option>--}}
{{--                                               <option value="FJ">Fiji</option>--}}
{{--                                               <option value="FI">Finnish</option>--}}
{{--                                               <option value="FR">French</option>--}}
{{--                                               <option value="KA">Georgian</option>--}}
{{--                                               <option value="DE">German</option>--}}
{{--                                               <option value="EL">Greek</option>--}}
{{--                                               <option value="GU">Gujarati</option>--}}
{{--                                               <option value="HE">Hebrew</option>--}}
{{--                                               <option value="HI">Hindi</option>--}}
{{--                                               <option value="HU">Hungarian</option>--}}
{{--                                               <option value="IS">Icelandic</option>--}}
{{--                                               <option value="ID">Indonesian</option>--}}
{{--                                               <option value="GA">Irish</option>--}}
{{--                                               <option value="IT">Italian</option>--}}
{{--                                               <option value="JA">Japanese</option>--}}
{{--                                               <option value="JW">Javanese</option>--}}
{{--                                               <option value="KO">Korean</option>--}}
{{--                                               <option value="LA">Latin</option>--}}
{{--                                               <option value="LV">Latvian</option>--}}
{{--                                               <option value="LT">Lithuanian</option>--}}
{{--                                               <option value="MK">Macedonian</option>--}}
{{--                                               <option value="MS">Malay</option>--}}
{{--                                               <option value="ML">Malayalam</option>--}}
{{--                                               <option value="MT">Maltese</option>--}}
{{--                                               <option value="MI">Maori</option>--}}
{{--                                               <option value="MR">Marathi</option>--}}
{{--                                               <option value="MN">Mongolian</option>--}}
{{--                                               <option value="NE">Nepali</option>--}}
{{--                                               <option value="NO">Norwegian</option>--}}
{{--                                               <option value="FA">Persian</option>--}}
{{--                                               <option value="PL">Polish</option>--}}
{{--                                               <option value="PT">Portuguese</option>--}}
{{--                                               <option value="PA">Punjabi</option>--}}
{{--                                               <option value="QU">Quechua</option>--}}
{{--                                               <option value="RO">Romanian</option>--}}
{{--                                               <option value="RU">Russian</option>--}}
{{--                                               <option value="SM">Samoan</option>--}}
{{--                                               <option value="SR">Serbian</option>--}}
{{--                                               <option value="SK">Slovak</option>--}}
{{--                                               <option value="SL">Slovenian</option>--}}
{{--                                               <option value="ES">Spanish</option>--}}
{{--                                               <option value="SW">Swahili</option>--}}
{{--                                               <option value="SV">Swedish </option>--}}
{{--                                               <option value="TA">Tamil</option>--}}
{{--                                               <option value="TT">Tatar</option>--}}
{{--                                               <option value="TE">Telugu</option>--}}
{{--                                               <option value="TH">Thai</option>--}}
{{--                                               <option value="BO">Tibetan</option>--}}
{{--                                               <option value="TO">Tonga</option>--}}
{{--                                               <option value="TR">Turkish</option>--}}
{{--                                               <option value="UK">Ukrainian</option>--}}
{{--                                               <option value="UR">Urdu</option>--}}
{{--                                               <option value="UZ">Uzbek</option>--}}
{{--                                               <option value="VI">Vietnamese</option>--}}
{{--                                               <option value="CY">Welsh</option>--}}
{{--                                               <option value="XH">Xhosa</option>--}}
                                           </select>

{{--                                           <script>--}}
{{--                                               $('#lang-name').change(function(){--}}
{{--                                                   var value = $(this).val().toLowerCase();--}}
{{--                                                   $('#language_name').val($("#lang-name option:selected").text());--}}
{{--                                                   $('#language_locale').val(value);--}}
{{--                                                   $('#iso_code').val(value);--}}
{{--                                                   console.log(value)--}}
{{--                                               });--}}
{{--                                           </script>--}}

                                           <input type="text"
                                                  class="form-control"
                                                  id="language_name"
                                                  required
                                                  name='name'
                                                  value="English"
                                                  style="display: none">

                                           <input type="text"
                                                  class="form-control"
                                                  id="language_locale"
                                                  required
                                                  name='locale'
                                                  value="en"
                                                  style="display: none">

                                           <input name="iso_code" value="en" id="iso_code" style="display: none">
                                           <input name="date_format" value="YYYY/MM/DD" style="display: none">
                                           <input checked style="display: none" name="active" value="1">


                                       </div>
                                  </div>
                              </div>
                            </div>
                        </div>

{{--                    FOOTER--}}
                        <div class="wizard-footer">
                            	<div class="pull-right">
                                    <input type='button' class='btn btn-next btn-fill btn-success btn-wd btn-sm' name='next' value='Next' />
                                    <input type='submit' class='btn btn-finish btn-fill btn-success btn-wd btn-sm' name='finish' value='Finish' />

                                </div>
                                <div class="pull-left">
                                    <input type='button' class='btn btn-previous btn-fill btn-default btn-wd btn-sm' name='previous' value='Previous' />
                                </div>
                                <div class="clearfix"></div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        </div>
    </div>

    <div class="footer">
        <div class="container">
					Created by Hessam CMS
        </div>
    </div>
</div>

</body>

	<!--   Core JS Files   -->
    <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap-wizard/1.2/jquery.bootstrap.wizard.min.js"></script>

	<!--  Plugin for the Wizard -->
    <script>
    searchVisible = 0;
    transparent = true;

    $(document).ready(function(){

        /*  Activate the tooltips      */
        $('[rel="tooltip"]').tooltip();

        // Code for the Validator
        var $validator = $('.wizard-card form').validate({
            rules: {
                firstname: {
                    required: true,
                    minlength: 3
                },
                lastname: {
                    required: true,
                    minlength: 3
                },
                email: {
                    required: true,
                    minlength: 3,
                }
            }
        });

        // Wizard Initialization
        $('.wizard-card').bootstrapWizard({
            'tabClass': 'nav nav-pills',
            'nextSelector': '.btn-next',
            'previousSelector': '.btn-previous',

            onNext: function(tab, navigation, index) {
                var $valid = $('.wizard-card form').valid();
                if(!$valid) {
                    $validator.focusInvalid();
                    return false;
                }
            },

            onInit : function(tab, navigation, index){

                //check number of tabs and fill the entire row
                var $total = navigation.find('li').length;
                $width = 100/$total;
                var $wizard = navigation.closest('.wizard-card');

                $display_width = $(document).width();

                if($display_width < 600 && $total > 3){
                    $width = 50;
                }

                navigation.find('li').css('width',$width + '%');
                $first_li = navigation.find('li:first-child a').html();
                $moving_div = $('<div class="moving-tab">' + $first_li + '</div>');
                $('.wizard-card .wizard-navigation').append($moving_div);
                refreshAnimation($wizard, index);
                $('.moving-tab').css('transition','transform 0s');
            },

            onTabClick : function(tab, navigation, index){

                var $valid = $('.wizard-card form').valid();

                if(!$valid){
                    return false;
                } else {
                    return true;
                }
            },

            onTabShow: function(tab, navigation, index) {
                var $total = navigation.find('li').length;
                var $current = index+1;

                var $wizard = navigation.closest('.wizard-card');

                // If it's the last tab then hide the last button and show the finish instead
                if($current >= $total) {
                    $($wizard).find('.btn-next').hide();
                    $($wizard).find('.btn-finish').show();
                } else {
                    $($wizard).find('.btn-next').show();
                    $($wizard).find('.btn-finish').hide();
                }

                button_text = navigation.find('li:nth-child(' + $current + ') a').html();

                setTimeout(function(){
                    $('.moving-tab').text(button_text);
                }, 150);

                var checkbox = $('.footer-checkbox');

                if( !index == 0 ){
                    $(checkbox).css({
                        'opacity':'0',
                        'visibility':'hidden',
                        'position':'absolute'
                    });
                } else {
                    $(checkbox).css({
                        'opacity':'1',
                        'visibility':'visible'
                    });
                }

                refreshAnimation($wizard, index);
            }
        });


        // Prepare the preview for profile picture
        $("#wizard-picture").change(function(){
            readURL(this);
        });

        $('[data-toggle="wizard-radio"]').click(function(){
            wizard = $(this).closest('.wizard-card');
            wizard.find('[data-toggle="wizard-radio"]').removeClass('active');
            $(this).addClass('active');
            $(wizard).find('[type="radio"]').removeAttr('checked');
            $(this).find('[type="radio"]').attr('checked','true');
        });

        $('[data-toggle="wizard-checkbox"]').click(function(){
            if( $(this).hasClass('active')){
                $(this).removeClass('active');
                $(this).find('[type="checkbox"]').removeAttr('checked');
            } else {
                $(this).addClass('active');
                $(this).find('[type="checkbox"]').attr('checked','true');
            }
        });

        $('.set-full-height').css('height', 'auto');

    });



    //Function to show image before upload

    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#wizardPicturePreview').attr('src', e.target.result).fadeIn('slow');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }

    $(window).resize(function(){
        $('.wizard-card').each(function(){
            $wizard = $(this);
            index = $wizard.bootstrapWizard('currentIndex');
            refreshAnimation($wizard, index);

            $('.moving-tab').css({
                'transition': 'transform 0s'
            });
        });
    });

    function refreshAnimation($wizard, index){
        total_steps = $wizard.find('li').length;
        move_distance = $wizard.width() / total_steps;
        step_width = move_distance;
        move_distance *= index;

        $wizard.find('.moving-tab').css('width', step_width);
        $('.moving-tab').css({
            'transform':'translate3d(' + move_distance + 'px, 0, 0)',
            'transition': 'all 0.3s ease-out'

        });
    }

    function debounce(func, wait, immediate) {
        var timeout;
        return function() {
            var context = this, args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(function() {
                timeout = null;
                if (!immediate) func.apply(context, args);
            }, wait);
            if (immediate && !timeout) func.apply(context, args);
        };
    };

</script>

	<!--  More information about jquery.validate here: http://jqueryvalidation.org/	 -->
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.2/dist/additional-methods.js"></script>

</html>
