@extends("binshopsblog_admin::layouts.admin_layout")
@section("content")


    <h5>Add new Language</h5>

    <form method='post' action='{{route("binshopsblog.admin.languages.store_language")}}'  enctype="multipart/form-data" >
        @csrf

        <div class="form-group">
            <select id="lang-name" data-placeholder="Choose a Language...">
                <option value="AF">Afrikaans</option>
                <option value="SQ">Albanian</option>
                <option value="AR">Arabic</option>
                <option value="HY">Armenian</option>
                <option value="EU">Basque</option>
                <option value="BN">Bengali</option>
                <option value="BG">Bulgarian</option>
                <option value="CA">Catalan</option>
                <option value="KM">Cambodian</option>
                <option value="ZH">Chinese (Mandarin)</option>
                <option value="HR">Croatian</option>
                <option value="CS">Czech</option>
                <option value="DA">Danish</option>
                <option value="NL">Dutch</option>
                <option value="EN">English</option>
                <option value="ET">Estonian</option>
                <option value="FJ">Fiji</option>
                <option value="FI">Finnish</option>
                <option value="FR">French</option>
                <option value="KA">Georgian</option>
                <option value="DE">German</option>
                <option value="EL">Greek</option>
                <option value="GU">Gujarati</option>
                <option value="HE">Hebrew</option>
                <option value="HI">Hindi</option>
                <option value="HU">Hungarian</option>
                <option value="IS">Icelandic</option>
                <option value="ID">Indonesian</option>
                <option value="GA">Irish</option>
                <option value="IT">Italian</option>
                <option value="JA">Japanese</option>
                <option value="JW">Javanese</option>
                <option value="KO">Korean</option>
                <option value="LA">Latin</option>
                <option value="LV">Latvian</option>
                <option value="LT">Lithuanian</option>
                <option value="MK">Macedonian</option>
                <option value="MS">Malay</option>
                <option value="ML">Malayalam</option>
                <option value="MT">Maltese</option>
                <option value="MI">Maori</option>
                <option value="MR">Marathi</option>
                <option value="MN">Mongolian</option>
                <option value="NE">Nepali</option>
                <option value="NO">Norwegian</option>
                <option value="FA">Persian</option>
                <option value="PL">Polish</option>
                <option value="PT">Portuguese</option>
                <option value="PA">Punjabi</option>
                <option value="QU">Quechua</option>
                <option value="RO">Romanian</option>
                <option value="RU">Russian</option>
                <option value="SM">Samoan</option>
                <option value="SR">Serbian</option>
                <option value="SK">Slovak</option>
                <option value="SL">Slovenian</option>
                <option value="ES">Spanish</option>
                <option value="SW">Swahili</option>
                <option value="SV">Swedish </option>
                <option value="TA">Tamil</option>
                <option value="TT">Tatar</option>
                <option value="TE">Telugu</option>
                <option value="TH">Thai</option>
                <option value="BO">Tibetan</option>
                <option value="TO">Tonga</option>
                <option value="TR">Turkish</option>
                <option value="UK">Ukrainian</option>
                <option value="UR">Urdu</option>
                <option value="UZ">Uzbek</option>
                <option value="VI">Vietnamese</option>
                <option value="CY">Welsh</option>
                <option value="XH">Xhosa</option>
            </select>
        </div>

        <div class="form-group">
            <label for="active"> Active</label>
            <input checked type="radio" id="active" name="active" value="1">
            <label for="deactive"> Deactive</label>
            <input type="radio" id="deactive" name="active" value="0">
            <br>

        </div>

        <div class="form-group">
            <span>RTL: </span>

            <label for="no">No</label>
            <input checked type="radio" id="no" name="rtl" value="0">
            <label for="yes">Yes</label>
            <input type="radio" id="yes" name="rtl" value="1">
            <br>
        </div>

        <script>
            $('#lang-name').change(function(){
                var value = $(this).val().toLowerCase();
                $('#language_name').val($("#lang-name option:selected").text());
                $('#language_locale').val(value);
                $('#iso_code').val(value);
                console.log(value)
            });
        </script>

        <div class="form-group">
            <label for="language_name">Language Name</label>

            <input type="text"
                   class="form-control"
                   id="language_name"
                   required
                   name='name'
                   readonly
            >

            <small id="language_name" class="form-text text-muted">The name of the language</small>

        </div>
        <div class="form-group">
            <label for="category_category_name">Locale</label>

            <input type="text"
                   class="form-control"
                   id="language_locale"
                   required
                   name='locale'
                   readonly
            >

            <small id="language_name" class="form-text text-muted">The locale of the language</small>

        </div>

        <input name="iso_code" value="" id="iso_code" style="display: none">
        <input name="date_format" value="YYYY/MM/DD" style="display: none">

        <input type='submit' class='btn btn-primary' value='Add New Language' >
    </form>

@endsection
