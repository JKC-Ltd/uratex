import { processActivePowerProfile } from "./activePower.js";
import { processVoltageCurrentProfile } from "./voltageCurrent.js";

// Process for the Previous and Present energy consumption calculation

let activePowerProfileDataId = $("#sensor-details-line").data('id');

processActivePowerProfile(activePowerProfileDataId);
processVoltageCurrentProfile(activePowerProfileDataId);
