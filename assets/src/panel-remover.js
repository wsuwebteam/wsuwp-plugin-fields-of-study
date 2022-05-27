window.addEventListener("load", () => {
    if (wp.data) {
        const editor = wp.data.dispatch("core/edit-post");
        editor.removeEditorPanel("taxonomy-panel-wsuwp_campus");
        editor.removeEditorPanel("taxonomy-panel-wsuwp_degree_type");
    }
});
