import { required, email, max,min, integer } from "vee-validate/dist/rules";
import { extend, localize } from "vee-validate";
import fr from 'vee-validate/dist/locale/fr.json';

localize('fr', fr);

extend("required", required);

extend("max", max);
extend("min", min);

extend("email", email);

extend("integer", integer);
