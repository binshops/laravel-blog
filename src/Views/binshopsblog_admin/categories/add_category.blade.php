@extends("binshopsblog_admin::layouts.admin_layout")
@section("content")

    <h5>Admin - Add Category</h5>
    <form method='post' action='{{route("binshopsblog.admin.categories.create_category")}}'  enctype="multipart/form-data" >

        @csrf

        <div class="form-group">
            <label for="language_list">Select Language</label>
            <select id="language_list" name='lang_id' class='form-control'>
                @foreach($language_list as $language)
                    <option  value='{{$language->id}}' @if($language->id == $language_id)selected="selected" @endif>
                        {{$language->name}}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="category_category_name">Category Name</label>

            <input type="text"
                   class="form-control"
                   id="category_name"
                   oninput="populate_slug_field();"
                   required
                   aria-describedby="category_category_name_help"
                   name='category_name'
                   value="{{old("category_name",$category_translation->category_name)}}"
            >

            <small id="category_category_name_help" class="form-text text-muted">The name of the category</small>
        </div>


        <div class="form-group">
            <label for="category_slug">Category slug</label>
            <input
                    maxlength='100'
                    pattern="[a-zA-Z0-9-]+"
                    type="text"
                    required
                    class="form-control"
                    id="category_slug"
                    oninput="SHOULD_AUTO_GEN_SLUG=false;"
                    aria-describedby="category_slug_help"
                    name='slug'
                    value="{{old("slug",$category_translation->slug)}}"
            >

            <small id="category_slug_help" class="form-text text-muted">
                Letters, numbers, dash only. The slug
                i.e. {{route("binshopsblog.view_category",[app('request')->get('locale'),""])}}/<u><em>this_part</em></u>. This must be unique (two categories can't
                share the same slug).

            </small>
        </div>

        <div class="form-group">
            <label for="category_slug">Category Tree</label>
            <ul class="wtree">
                @include("binshopsblog_admin::categories._category_partial", ['category_tree' => $cat_roots])
            </ul>
        </div>

        <div class="form-group">
            <label for="category_slug">Parent Category</label>
            <select id="parent_id" name='parent_id' class='form-control'>
                <option  selected='selected' value='0'>
                    Root
                </option>
                @foreach($category_tree as $category)
                    <option  value='{{$category->categoryTranslations[0]['category_id']}}'>
                        {{$category->categoryTranslations[0]['category_name']}}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="category_description">Category Description (optional)</label>
            <textarea name='category_description'
                      class='form-control'
                      id='category_description'>{{old("category_description",$category_translation->category_description)}}</textarea>

        </div>

        <button type="button" class='btn btn-primary' id="submit-btn">Add new category</button>

        <script>
            SHOULD_AUTO_GEN_SLUG = false;

            /* Generate the slug field, if it was not touched by the user (or if it was an empty string) */
            function populate_slug_field() {

//        alert("A");
                var cat_slug = document.getElementById('category_slug');

                if (cat_slug.value.length < 1) {
                    // if the slug field is empty, make sure it auto generates
                    SHOULD_AUTO_GEN_SLUG = true;
                }

                if (SHOULD_AUTO_GEN_SLUG) {
                    // the slug hasn't been manually changed (or it was set above), so we should generate the slug
                    // This is done in two stages - one to remove non words/spaces etc, the another to replace white space (and underscore) with a -
                    cat_slug.value =document.getElementById("category_name").value.toLowerCase()
                        .replace(/[^\w-_ ]+/g, '') // replace with nothing
                        .replace(/[_ ]+/g, '-') // replace _ and spaces with -
                        .substring(0,99); // limit str length

                }

            }

            if (document.getElementById("category_slug").value.length < 1) {
                SHOULD_AUTO_GEN_SLUG = true;
            } else {
                SHOULD_AUTO_GEN_SLUG = false; // there is already a value in #category_slug, so lets pretend it was changed already.
            }


            //multi-language data
            var defalutLangId = {{$language_id}};
            var preLangId = defalutLangId;
            var languageList = {};
            $("#language_list > option").each(function() {
                languageList[this.value] = {
                    lang_id: -1,
                    category_name: "",
                    slug: "",
                    category_description: "",
                    lang_name: this.text
                }
            });

            $('#language_list').on('change', function() {
                fillLanguageList(this.value);
                preLangId = this.value;
            });

            function fillLanguageList(langId){
                languageList[preLangId].lang_id = preLangId;
                languageList[preLangId].category_name = $('#category_name').val();
                languageList[preLangId].slug = $('#category_slug').val();
                languageList[preLangId].category_description = $('#category_description').val();

                $('#category_name').val(languageList[langId].category_name);
                $('#category_slug').val(languageList[langId].slug);
                $('#category_description').val(languageList[langId].category_description);
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#submit-btn').click(function (){
                if (languageList[$('#language_list').val()].lang_id == -1){
                    if (!$('#category_name').val()){
                        alert("Category name must not be empty");
                        return ;
                    }else if (!$('#category_slug').val()){
                        alert("Category slug must not be empty");
                        return ;
                    }
                    languageList[preLangId].lang_id = $('#language_list').val();
                    languageList[preLangId].category_name = $('#category_name').val();
                    languageList[preLangId].slug = $('#category_slug').val();
                    languageList[preLangId].category_description = $('#category_description').val();
                }
                $.post('{{route("binshopsblog.admin.categories.store_category")}}' ,
                    {
                        data: languageList,
                        parent_id: parseInt($('#parent_id').val())
                    },
                    function(data, status){
                        if (data.code === 403){
                            alert("Slug is already taken: " + languageList[data.data].lang_name);
                        }else if (data.code === 200) {
                        }
                        window.location.replace("{{route('binshopsblog.admin.categories.index')}}");
                    });
            });

        </script>
    </form>

@endsection
