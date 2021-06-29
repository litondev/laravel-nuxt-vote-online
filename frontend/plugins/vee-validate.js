import { extend } from "vee-validate";
import { required,email,min,max } from "vee-validate/dist/rules";

extend("required",required);

extend("min",min);

extend("max",max);

extend("email",email);