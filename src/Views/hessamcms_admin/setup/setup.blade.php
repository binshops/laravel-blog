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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <link href="{{ asset('admin-setup.css') }}" rel="stylesheet">
</head>

<body>
<div style="background-color: #e2e8f0">

    <div class="container">
        <div class="row">
            <div class="col-sm-8 col-sm-offset-2">

                <div class="wizard-container">
                    <div class="card wizard-card" data-color="green" id="wizard">
                        <form action="{{route("hessamcms.admin.setup_submit")}}" method="post">
                            @csrf

                            <div class="wizard-header" style="padding: 10px; text-align: center">

                                <svg version="1.0" xmlns="http://www.w3.org/2000/svg"
                                     width="197.000000pt" height="65.000000pt" viewBox="0 0 197.000000 65.000000"
                                     preserveAspectRatio="xMidYMid meet">

                                    <g transform="translate(0.000000,65.000000) scale(0.100000,-0.100000)"
                                       fill="#000000" stroke="none">
                                        <path style="fill: #2787AC;" d="M424 636 c-20 -22 -38 -60 -59 -125 -20 -62 -22 -64 -74 -83 -29 -11
-55 -18 -57 -15 -3 3 10 45 29 93 19 49 31 93 27 97 -12 13 -59 -3 -75 -25 -7
-12 -28 -65 -45 -119 -32 -99 -32 -99 -85 -131 -52 -31 -86 -71 -71 -85 3 -4
27 3 51 15 25 12 48 22 51 22 6 0 3 -33 -12 -131 -6 -40 13 -69 46 -69 14 0
19 11 25 58 3 31 13 87 21 123 15 65 15 65 66 87 28 12 53 21 54 19 2 -1 -8
-56 -21 -122 -31 -155 -33 -220 -4 -235 36 -20 46 -6 59 87 16 121 56 295 70
303 6 4 53 15 105 25 101 20 114 32 69 62 -23 15 -33 15 -86 4 -33 -7 -63 -10
-66 -7 -3 3 7 36 21 74 15 37 27 73 27 80 0 16 -52 15 -66 -2z"/>
                                        <path style="fill: #b6b8ba;" d="M1422 340 c-72 -32 -91 -113 -40 -167 29 -32 78 -30 108 2 17 19 21
28 13 36 -9 9 -19 6 -39 -10 -24 -19 -30 -20 -48 -8 -39 26 -30 81 19 113 19
13 27 13 44 2 23 -14 36 -6 28 16 -12 30 -41 36 -85 16z"/>
                                        <path style="fill: #b6b8ba;" d="M1686 339 c-9 -13 -16 -26 -16 -30 0 -4 -7 -24 -16 -45 l-16 -38 -31
60 c-45 84 -64 83 -72 -3 -11 -122 -11 -127 6 -131 12 -2 18 10 25 55 l9 58
28 -53 c16 -29 33 -52 40 -49 7 2 20 27 31 55 10 28 22 50 26 47 4 -3 11 -30
15 -60 4 -35 11 -55 20 -55 22 0 23 21 6 107 -20 97 -32 115 -55 82z"/>
                                        <path style="fill: #b6b8ba;" d="M1802 334 c-17 -12 -22 -24 -20 -47 3 -27 9 -34 48 -47 46 -16 63
-43 34 -54 -9 -3 -30 1 -47 9 -20 10 -34 12 -40 6 -14 -14 8 -38 48 -51 38
-12 58 -6 90 30 18 20 18 23 3 48 -10 16 -34 33 -58 42 -54 19 -56 34 -5 38
47 4 67 18 45 32 -23 15 -73 12 -98 -6z"/>
                                        <path style="fill: #b6b8ba;" d="M608 286 c-14 -32 -5 -53 29 -68 37 -16 36 -15 28 -28 -5 -8 -14 -6
-32 5 -36 24 -56 3 -26 -26 26 -27 72 -28 90 -3 21 29 12 57 -24 74 -39 18
-44 35 -8 26 29 -7 48 20 24 35 -28 18 -69 10 -81 -15z"/>
                                        <path style="fill: #b6b8ba;" d="M737 289 c-21 -29 -10 -55 29 -74 19 -9 32 -21 28 -26 -3 -6 -15 -4
-31 6 -33 22 -55 5 -29 -24 39 -43 96 -25 96 30 0 25 -6 33 -30 42 -36 14 -40
32 -6 23 29 -7 43 9 26 29 -18 22 -66 19 -83 -6z"/>
                                        <path style="fill: #b6b8ba;" d="M1014 296 c-3 -7 -4 -42 -2 -77 2 -51 6 -64 21 -67 14 -3 17 5 17 52
0 31 5 56 10 56 6 0 13 1 18 3 4 1 9 -23 12 -53 4 -40 9 -55 20 -55 11 0 16
15 20 55 4 40 9 55 20 55 11 0 16 -14 18 -58 3 -49 6 -58 20 -55 18 3 29 70
18 113 -7 29 -51 49 -77 35 -11 -6 -24 -8 -31 -4 -21 13 -79 13 -84 0z"/>
                                        <path style="fill: #b6b8ba;" d="M460 282 c-28 -23 -31 -83 -5 -112 29 -32 115 -21 115 15 0 11 -11
14 -47 10 -47 -5 -47 -4 -15 7 72 25 78 98 8 98 -19 0 -44 -8 -56 -18z m65
-31 c-6 -5 -21 -12 -35 -16 -22 -7 -23 -6 -11 9 7 9 23 16 34 16 13 0 17 -4
12 -9z"/>
                                        <path style="fill: #b6b8ba;" d="M886 274 c-19 -19 -26 -37 -26 -64 0 -49 15 -60 78 -59 l51 2 -5 61
c-3 33 -7 67 -10 74 -6 22 -60 14 -88 -14z m54 -48 c0 -31 -19 -53 -34 -39
-10 11 -7 48 6 61 20 20 28 14 28 -22z"/>
                                    </g>
                                </svg>


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
                                            <h4 class="info-text">Your default language is set to English. You can add more language from admin panel.</h4>

                                            <h6 class="info-text">
                                                Version v9.0.x
                                            </h6>
                                        </div>
                                        {{--                                        <div class="col-sm-12">--}}
                                        {{--                                            <div class="form-group">--}}
                                        {{--                                                <label>Language</label><br>--}}
                                        {{--                                                <select readonly class="form-control" id="lang-name" data-placeholder="Choose a Language...">--}}
                                        {{--                                                    --}}{{--                                               <option value="AF">Afrikaans</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="SQ">Albanian</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="AR">Arabic</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="HY">Armenian</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="EU">Basque</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="BN">Bengali</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="BG">Bulgarian</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="CA">Catalan</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="KM">Cambodian</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="ZH">Chinese (Mandarin)</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="HR">Croatian</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="CS">Czech</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="DA">Danish</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="NL">Dutch</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="EN">English</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="ET">Estonian</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="FJ">Fiji</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="FI">Finnish</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="FR">French</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="KA">Georgian</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="DE">German</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="EL">Greek</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="GU">Gujarati</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="HE">Hebrew</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="HI">Hindi</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="HU">Hungarian</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="IS">Icelandic</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="ID">Indonesian</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="GA">Irish</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="IT">Italian</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="JA">Japanese</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="JW">Javanese</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="KO">Korean</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="LA">Latin</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="LV">Latvian</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="LT">Lithuanian</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="MK">Macedonian</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="MS">Malay</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="ML">Malayalam</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="MT">Maltese</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="MI">Maori</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="MR">Marathi</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="MN">Mongolian</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="NE">Nepali</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="NO">Norwegian</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="FA">Persian</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="PL">Polish</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="PT">Portuguese</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="PA">Punjabi</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="QU">Quechua</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="RO">Romanian</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="RU">Russian</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="SM">Samoan</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="SR">Serbian</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="SK">Slovak</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="SL">Slovenian</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="ES">Spanish</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="SW">Swahili</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="SV">Swedish </option>--}}
                                        {{--                                                    --}}{{--                                               <option value="TA">Tamil</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="TT">Tatar</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="TE">Telugu</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="TH">Thai</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="BO">Tibetan</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="TO">Tonga</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="TR">Turkish</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="UK">Ukrainian</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="UR">Urdu</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="UZ">Uzbek</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="VI">Vietnamese</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="CY">Welsh</option>--}}
                                        {{--                                                    --}}{{--                                               <option value="XH">Xhosa</option>--}}
                                        {{--                                                </select>--}}

                                        {{--                                                --}}{{--                                           <script>--}}
                                        {{--                                                --}}{{--                                               $('#lang-name').change(function(){--}}
                                        {{--                                                --}}{{--                                                   var value = $(this).val().toLowerCase();--}}
                                        {{--                                                --}}{{--                                                   $('#language_name').val($("#lang-name option:selected").text());--}}
                                        {{--                                                --}}{{--                                                   $('#language_locale').val(value);--}}
                                        {{--                                                --}}{{--                                                   $('#iso_code').val(value);--}}
                                        {{--                                                --}}{{--                                                   console.log(value)--}}
                                        {{--                                                --}}{{--                                               });--}}
                                        {{--                                                --}}{{--                                           </script>--}}

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


                                        {{--                                            </div>--}}
                                        {{--                                        </div>--}}



                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12" style="text-align: center">
                                    <input type='submit' class='btn  btn-fill btn-success btn-wd btn-sm' value='Setup Package' />

                                </div>
                            </div>
                            {{--                    FOOTER--}}
                            {{--                            <div class="wizard-footer ">--}}
                            {{--                                <div class="pull-right">--}}
                            {{--                                    <input type='button' class='btn btn-next btn-fill btn-success btn-wd btn-sm' name='next' value='Next' />--}}
                            {{--                                    <input type='submit' class='btn btn-finish btn-fill btn-success btn-wd btn-sm' name='finish' value='Finish' />--}}

                            {{--                                </div>--}}
                            {{--                                <div class="pull-left">--}}
                            {{--                                    <input type='button' class='btn btn-previous btn-fill btn-default btn-wd btn-sm' name='previous' value='Previous' />--}}
                            {{--                                </div>--}}
                            {{--                                <div class="clearfix"></div>--}}
                            {{--                            </div>--}}

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

<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap-wizard/1.2/jquery.bootstrap.wizard.js"></script>

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
<script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js"></script>

</html>
