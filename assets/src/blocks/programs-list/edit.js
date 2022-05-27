const { InspectorControls } = wp.blockEditor;
const { PanelBody, CheckboxControl, SelectControl } = wp.components;

import React, { useState, useEffect } from "react";

import "./styles.scss";

const CSSNAMESPACE = "wsu-gutenberg-programs-list";

const examplePrograms = [
    {
        group: "A",
        programs: [
            {
                name: "Acting",
                degreeOptions: ["Major", "Minor"],
                hasLink: true,
            },
            {
                name: "Africana Studies",
                degreeOptions: ["Major", "Certificate"],
                hasLink: true,
            },
            {
                name: "American Studies",
                degreeOptions: ["Minor"],
                hasLink: false,
            },
            {
                name: "Anthropology",
                degreeOptions: ["Major", "Minor", "Certificate"],
                hasLink: true,
            },
        ],
    },
    {
        group: "B",
        programs: [
            {
                name: "Biochemistry",
                degreeOptions: ["Minor", "Certificate"],
                hasLink: false,
            },
            {
                name: "Bioinformatics",
                degreeOptions: ["Major", "Minor"],
                hasLink: true,
            },
            { name: "Biology", degreeOptions: ["Certificate"], hasLink: false },
            {
                name: "Business Analytics",
                degreeOptions: ["Major", "Minor", "Certificate"],
                hasLink: true,
            },
        ],
    },
];

export default function Edit(props) {
    const { attributes, setAttributes } = props;

    return (
        <>
            <InspectorControls>
                <PanelBody title="Content Settings" initialOpen={true}>
                    <SelectControl
                        label="Link Group Heading Tag"
                        value={attributes.headingLevel}
                        options={[
                            { label: "H2", value: "h2" },
                            { label: "H3", value: "h3" },
                            { label: "H4", value: "h4" },
                            { label: "H5", value: "h5" },
                            { label: "H6", value: "h6" },
                        ]}
                        onChange={(tag) => setAttributes({ headingLevel: tag })}
                    />

                    <CheckboxControl
                        label="Show Filters"
                        help="Show search and taxonomy filters."
                        checked={attributes.showFilters}
                        onChange={(val) => setAttributes({ showFilters: val })}
                    />
                </PanelBody>
            </InspectorControls>

            <div className={`${CSSNAMESPACE}`}>
                <div className={`${attributes.className || ""}`}>
                    {!attributes.showFilters && (
                        <>
                            <div className={`${CSSNAMESPACE}__controls`}>
                                <div
                                    className={`${CSSNAMESPACE}__control--search`}
                                >
                                    <input
                                        className={`${CSSNAMESPACE}__search-input`}
                                        type="text"
                                        placeholder="Search Degree Programs"
                                    />
                                </div>

                                <div
                                    className={`${CSSNAMESPACE}__control-group js-programs-list__select-controls`}
                                >
                                    <div
                                        className={`${CSSNAMESPACE}__control--select`}
                                    >
                                        <button
                                            className={`${CSSNAMESPACE}__control-button wsu-button wsu-button--tertiary wsu-button--size-small`}
                                            aria-expanded="false"
                                        >
                                            <span
                                                className={`${CSSNAMESPACE}__button-text`}
                                            >
                                                Area of Interest
                                            </span>
                                            <i
                                                className={`${CSSNAMESPACE}__button-icon wsu-icon wsu-i-arrow-down-carrot`}
                                            ></i>
                                        </button>
                                    </div>
                                    <div
                                        className={`${CSSNAMESPACE}__control--select`}
                                    >
                                        <button
                                            className={`${CSSNAMESPACE}__control-button wsu-button wsu-button--tertiary wsu-button--size-small`}
                                            aria-expanded="false"
                                        >
                                            <span
                                                className={`${CSSNAMESPACE}__button-text`}
                                            >
                                                Degree Type
                                            </span>
                                            <i
                                                className={`${CSSNAMESPACE}__button-icon wsu-icon wsu-i-arrow-down-carrot`}
                                            ></i>
                                        </button>
                                    </div>

                                    <div
                                        className={`${CSSNAMESPACE}__control--select`}
                                    >
                                        <button
                                            className={`${CSSNAMESPACE}__control-button wsu-button wsu-button--tertiary wsu-button--size-small`}
                                            aria-expanded="false"
                                        >
                                            <span
                                                className={`${CSSNAMESPACE}__button-text`}
                                            >
                                                Campus
                                            </span>
                                            <i
                                                className={`${CSSNAMESPACE}__button-icon wsu-icon wsu-i-arrow-down-carrot`}
                                            ></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </>
                    )}

                    {examplePrograms.map((group) => (
                        <div
                            key={group.group}
                            className={`${CSSNAMESPACE}__list-group`}
                        >
                            <attributes.headingLevel
                                className={`${CSSNAMESPACE}__list-heading`}
                            >
                                {group.group}
                            </attributes.headingLevel>
                            <ol className={`${CSSNAMESPACE}__list`}>
                                {group.programs.map((p) => (
                                    <li
                                        className={`${CSSNAMESPACE}__list-item`}
                                    >
                                        {p.hasLink ? (
                                            <a
                                                href="#"
                                                className={`${CSSNAMESPACE}__list-link`}
                                            >
                                                {p.name}
                                            </a>
                                        ) : (
                                            <span
                                                className={`${CSSNAMESPACE}__list-link`}
                                            >
                                                {p.name}
                                            </span>
                                        )}

                                        <div
                                            className={`${CSSNAMESPACE}__degree-types`}
                                        >
                                            {p.degreeOptions.map((d) => (
                                                <span
                                                    className={`${CSSNAMESPACE}__degree-type`}
                                                >
                                                    {d}
                                                </span>
                                            ))}
                                        </div>
                                    </li>
                                ))}
                                <li className={`${CSSNAMESPACE}__list-item`}>
                                    <span
                                        className={`${CSSNAMESPACE}__list-link`}
                                    >
                                        &hellip;
                                    </span>
                                </li>
                            </ol>
                        </div>
                    ))}
                </div>
            </div>
        </>
    );
}
