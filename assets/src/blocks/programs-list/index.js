import { registerBlockType } from "@wordpress/blocks";

import Edit from "./edit";

registerBlockType("wsuwp/programs-list", {
    title: "Programs List",
    icon: "welcome-learn-more",
    category: "advanced",
    attributes: {
        headingLevel: {
            type: "string",
            default: "h2",
        },
        showAllLinks: {
            type: "boolean",
            default: false,
        },
    },
    edit: Edit,
    save: function () {
        return null;
    },
});
