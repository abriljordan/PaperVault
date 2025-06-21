import js from '@eslint/js';
import typescript from 'typescript-eslint';

export default [
    js.configs.recommended,
    ...typescript.configs.recommended,
    {
        files: ['resources/js/**/*.js', 'resources/js/**/*.ts'],
        languageOptions: {
            ecmaVersion: 2020,
            sourceType: 'module',
        },
        rules: {
            'no-unused-vars': 'warn',
            'no-console': 'warn',
        },
    },
];
