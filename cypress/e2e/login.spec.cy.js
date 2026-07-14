// cypress/e2e/login.spec.js
describe('Teste de Layout e Login de Tela', () => {
    it('Deve verificar se o layout do cabeçalho está adequado', () => {
        cy.visit('http://localhost:8000'); // URL onde o PHP está rodando
        cy.get('header').should('have.css', 'background-color', 'rgb(44, 62, 80)');
        cy.contains('TestLab Academy').should('be.visible');
    });

    it('Deve realizar o login com sucesso via interface gráfica', () => {
        cy.visit('http://localhost:8000');
        
        // Simula o usuário preenchendo os dados
        cy.get('input[name="login"]').type('admin');
        cy.get('input[name="senha"]').type('password');
        // O Cypress busca especificamente pelo ID do botão de login
        cy.get('#btn-login').click();
        // Verifica se a mensagem de sucesso aparece com a classe correta (verde)
        cy.get('.alert').should('contain', 'Login realizado com sucesso');
        cy.get('.alert').should('have.class', 'success');
    });
});