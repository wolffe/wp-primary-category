# WordPress Primary Category

Set a primary category for your (custom) posts and query them in your template using native WordPress queries.

## Assumptions

* Custom post types use the native category taxonomy - `'taxonomies' => array('category')`

## Further improvements:

* Dynamically show/hide `_builtin` post types (default to show)
* Dynamically show/hide non-public (non-publicly queryable) post types (default to hide)
* Add better communication between the Primary Category metabox and the Category metabox (anchor links or JavaScript appending)
* Add more contextual help to both the metabox and the plugin's settings
* Add/extend functionality to allow for primary taxonomies by getting all taxonomies attached to a custom post and adding the same functionality as for categories

## Context

Depending on the publisher's implementation and use of Yoast SEO plugin (which already has this functionality), a query can be built using the plugin's code without adding any metaboxes or custom plugin settings. For this plugin, though, I have created the solution 100% from scratch.
