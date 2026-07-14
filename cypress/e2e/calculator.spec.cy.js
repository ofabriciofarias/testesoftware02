// cypress/e2e/calculadora.spec.cy.js

describe('Testes Visuais da Calculadora', () => {
    
    it('Deve realizar uma soma de 50 e 75 e abrir o modal com o resultado 125', () => {
        // 1. Acessa a aplicação
        cy.visit('http://localhost:8000');

        // 2. Localiza e preenche o primeiro campo
        cy.get('#num1').type('50');

        // 3. Localiza e preenche o segundo campo
        cy.get('#num2').type('75');

        // 4. Submete o formulário
        cy.get('#btn-somar').click();

        // 5. Validações de interface (Modal)
        // Garante que o modal perdeu o "display: none"
        cy.get('#meuModal').should('be.visible');
        
        // Garante que o texto renderizado no HTML é a resposta matemática correta
        cy.get('#resultado-valor').should('have.text', '125');
    });

});