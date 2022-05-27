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
        showFilters: {
            type: "boolean",
            default: true,
        },
    },
    edit: Edit,
    save: function () {
        return null;
    },
});
