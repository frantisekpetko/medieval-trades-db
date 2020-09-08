import Generator from 'yeoman-generator';


class extends Generator {
    constructor(args, options) {
        super(args, options);
    }

    // first stage
    async prompting() {
        this.log('Generator starting... 🤖');
    }

    // second stage
    writing() {
        this.log('Writing files... 📝');
    }

    // last stage
    end() {
        this.log('Bye... 👋');
    }

    generate(module, dependencyTemplates, runtimeTemplate, type) {
        return undefined;
    }
}

export default Generator;