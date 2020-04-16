<div class="form-group">
    <label for="category_name">
        Category Name
    </label>

    <input type="text"
           class="form-control"
           id="category_name"
           required
           aria-describedby="category_name_help"
           name="category_name"
           value="{{ old('category_name', $category->category_name) }}"
    >

    <small id="category_name_help" class="form-text text-muted">The name of the category</small>
</div>

<div class="form-group">
    <label for="category_slug">
        Category Slug
    </label>
    <input maxlength="100" pattern="[a-zA-Z0-9-]+" type="text" required
            class="form-control" id="category_slug" aria-describedby="category_slug_help"
           name="slug" value="{{ old('slug',$category->slug) }}">

    <small id="category_slug_help" class="form-text text-muted">
        Letters, numbers, dash only. The slug i.e.
        {{ route('blogetc.view_category', '' )}}/<u><em>this_part</em></u>.
        This must be unique (two categories can't share the same slug).
    </small>
</div>

<div class="form-group">
    <label for="category_description">
        Category Description (optional)
    </label>
    <textarea name="category_description"
              class="form-control"
              id="category_description">{{ old('category_description', $category->category_description) }}</textarea>
</div>

@push('js')
    <script>
        /**
         * Generate the category slug, based on the category name.
         *
         * This is only run if the slug did not exist on page load,
         * and has not been edited by a user since page load.
         */
        (function autoSlugCategory () {
            // Get the two inputs:
            var categoryNameInput = document.getElementById('category_name');
            var slugInput = document.getElementById('category_slug');

            // Initially, only enable generating slug if slug originally had no value.
            var shouldGenerateSlug = slugInput.value.length === 0;

            /**
             * Function to generate a URL friendly 'slug' from value
             *
             * @param value
             * @returns {string}
             */
            var slug = function (value) {
                return value.toLowerCase()
                            .replace(/[^\w-_ ]+/g, '') // remove invalid characters
                            .replace(/[_ ]+/g, '-') // replace underscores and spaces with '-'
                            .substring(0, 100); // limit length to 100 characters
            };

            /**
             * Function to generate the slug (if required) - called as an event listener.
             */
            var updateSlug = function () {
                // check if slug value is empty, if so then force shouldGenerateSlug to true
                shouldGenerateSlug = slugInput.value.length === 0
                    ? true // enable generating slug
                    : shouldGenerateSlug; // default to its initial value

                if (shouldGenerateSlug === false || categoryNameInput.value.length === 0) {
                    return;
                }

                slugInput.value = slug(categoryNameInput.value);
            };

            /**
             * Disable generating of slug - called when the slug input is updated
             *
             * Only enable it if text input was cleared
             */
            var disable = function () {
                shouldGenerateSlug = slugInput.length === 0;
            };

            // when category name is updated, generate slug (if enabled):
            categoryNameInput.addEventListener('input', updateSlug);

            // if the slug field is changed, disable future auto update:
            slugInput.addEventListener('input', disable);
        })();
    </script>
@endpush
