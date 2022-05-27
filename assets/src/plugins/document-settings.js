import { useSelect, useDispatch } from "@wordpress/data";
import { PluginDocumentSettingPanel } from "@wordpress/edit-post";
import { TextControl } from "@wordpress/components";
import { registerPlugin } from "@wordpress/plugins";
import CampusDegreesEditor from "../campus-degrees-editor";

const ProgramSettingsPanels = () => {
    const postType = useSelect((select) => {
        return select("core/editor").getCurrentPostType();
    });

    if (postType !== "program") return null;

    const { editPost } = useDispatch("core/editor");
    const postMeta = useSelect((select) => {
        return select("core/editor").getEditedPostAttribute("meta");
    });

    function updatePostMetaField(key, value) {
        editPost({
            meta: {
                ...postMeta,
                [key]: value,
            },
        });
    }

    // open panel by default
    if (
        !wp.data
            .select("core/edit-post")
            .isEditorPanelOpened(
                "plugin-wsuwp-program-settings-panels/program-settings-panel"
            )
    ) {
        wp.data
            .dispatch("core/edit-post")
            .toggleEditorPanelOpened(
                "plugin-wsuwp-program-settings-panels/program-settings-panel"
            );
    }

    return (
        <>
            <PluginDocumentSettingPanel
                name="program-settings-panel"
                title="Program Settings"
                className="program-settings-panel"
            >
                <TextControl
                    label="Program Link"
                    help="Enter full url to program page"
                    value={postMeta.wsuwp_program_url}
                    onChange={(value) =>
                        updatePostMetaField("wsuwp_program_url", value)
                    }
                    placeholder={
                        "https://admission.wsu.edu/academics/fos/Public/field.castle?id=1234"
                    }
                />
            </PluginDocumentSettingPanel>

            <PluginDocumentSettingPanel
                name="program-campus-degrees-panel"
                title="Campus Degree Options"
                className="program-campus-degrees-panel"
            >
                <CampusDegreesEditor />
            </PluginDocumentSettingPanel>
        </>
    );
};

registerPlugin("plugin-wsuwp-program-settings-panels", {
    render: ProgramSettingsPanels,
    icon: null,
});
