import { useEffect } from "@wordpress/element";
import { useSelect, useDispatch } from "@wordpress/data";
import TokenMultiSelectControl from "../../../wsuwp-plugin-gutenberg/assets/src/js/partials/block-controls/token-multiselect-control";

function CampusDegreesEditor() {
    const { editPost } = useDispatch("core/editor");
    const { degreeTypes, campuses, postMeta } = useSelect((select) => {
        const { getEntityRecords } = select("core");
        const args = {
            per_page: -1,
            orderby: "name",
            order: "asc",
            _fields: "id,name,slug",
        };

        return {
            degreeTypes: getEntityRecords(
                "taxonomy",
                "wsuwp_degree_type",
                args
            ),
            campuses: getEntityRecords("taxonomy", "wsuwp_campus", args),
            postMeta: select("core/editor").getEditedPostAttribute("meta"),
        };
    }, []);

    function handleSelectionChange(key, value) {
        const updatedMeta = getUpdatedPostMeta(key, value);
        const selectedCampuses = getNonEmptyCampuses(
            updatedMeta["wsuwp_program_campus_degrees"]
        );
        const selectedDegreeTypes = getSelectedDegreeTypes(
            updatedMeta["wsuwp_program_campus_degrees"]
        );

        editPost({
            meta: updatedMeta,
            wsuwp_campus: selectedCampuses,
            wsuwp_degree_type: selectedDegreeTypes,
        });
    }

    function getUpdatedPostMeta(key, value) {
        return {
            ...postMeta,
            wsuwp_program_campus_degrees: {
                ...postMeta["wsuwp_program_campus_degrees"],
                [key]: value,
            },
        };
    }

    function getNonEmptyCampuses(campusDegrees) {
        return Object.keys(campusDegrees).filter(
            (campus) => campusDegrees[campus].length > 0
        );
    }

    function getSelectedDegreeTypes(campusDegrees) {
        return Object.keys(campusDegrees).reduce((acc, campus) => {
            const degreeTypes = campusDegrees[campus];
            degreeTypes.forEach((degreeType) => {
                if (!acc.includes(degreeType)) {
                    acc.push(degreeType);
                }
            });

            return acc;
        }, []);
    }

    if (
        degreeTypes &&
        degreeTypes.length > 0 &&
        campuses &&
        campuses.length > 0 &&
        postMeta
    ) {
        const degreeOptions = degreeTypes.map((c) => {
            return { value: c.id, label: c.name };
        });

        return (
            <>
                {campuses.map((campus) => {
                    const value =
                        postMeta["wsuwp_program_campus_degrees"] &&
                        postMeta["wsuwp_program_campus_degrees"][campus.id]
                            ? postMeta["wsuwp_program_campus_degrees"][
                                  campus.id
                              ]
                            : [];
                    return (
                        <TokenMultiSelectControl
                            label={campus.name + " Degree Options"}
                            help="Select the degree options for this campus."
                            value={value}
                            options={degreeOptions}
                            onChange={(value) => {
                                handleSelectionChange(campus.id, value);
                            }}
                        />
                    );
                })}
            </>
        );
    } else {
        return <p>Loading...</p>;
    }
}

export default CampusDegreesEditor;
