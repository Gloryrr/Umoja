import React, { useState } from 'react';
import { Label, Button } from 'flowbite-react';

interface SelectCheckboxProps {
    options: Array<{ label: string; value: string }>;
    selectedValues: string[];
    onSelectionChange: (selected: string[]) => void;
    domaineSelection: string;
}

const SelectCheckbox: React.FC<SelectCheckboxProps> = ({ domaineSelection, options, selectedValues, onSelectionChange }) => {
    const [isOpen, setIsOpen] = useState(false);

    const handleCheckboxChange = (value: string, checked: boolean) => {
        const updatedValues = checked
            ? [...selectedValues, value]
            : selectedValues.filter((item) => item !== value);
        onSelectionChange(updatedValues);
    };

    return (
        <div className="relative">
            <Label htmlFor="checkbox-select" value={`${domaineSelection}`} />
            <Button
                id="checkbox-select"
                onClick={() => setIsOpen(!isOpen)}
                className="w-full"
                color="gray"
            >
                {selectedValues.length > 0
                    ? `Sélectionné(s): ${selectedValues.length}`
                    : "Sélectionnez vos critères"}
            </Button>
            {isOpen && (
                <div className="absolute z-10 mt-2 w-full bg-white border rounded-lg shadow-lg p-2">
                    {/* Conteneur scrollable */}
                    <div className="max-h-60 overflow-y-auto">
                        {options.map((option, index) => (
                            <label key={index} className="flex items-center space-x-2 p-1">
                                <input
                                    type="checkbox"
                                    value={option.value}
                                    checked={selectedValues.includes(option.value)}
                                    onChange={(e) =>
                                        handleCheckboxChange(option.value, e.target.checked)
                                    }
                                />
                                <span>{option.label}</span>
                            </label>
                        ))}
                    </div>
                    <Button
                        onClick={() => setIsOpen(false)}
                        size="sm"
                        color="gray"
                        className="mt-2 w-full"
                    >
                        Fermer
                    </Button>
                </div>
            )}
        </div>
    );
};

export default SelectCheckbox;
