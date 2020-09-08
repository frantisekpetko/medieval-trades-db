import prettier from "prettier/standalone";
import phpPlugin from "@prettier/plugin-php/standalone";

prettier.format("code", {
    plugins: [phpPlugin],
    parser: "php",
});
