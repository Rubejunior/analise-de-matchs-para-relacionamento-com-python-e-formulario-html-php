## Descrição do Projeto

site com formulario: 
https://www.casamentonaweb.com.br/


Este projeto consiste de uma brincadeira que surgiu no app Threads e acabou gerando esse trabalho vonluntário que consiste em um formulário web para capturar intenções de relacionamento, hospedado na Hostinger mas com futuro desejo de hospedar em Heroku para tambem fazer as analises via SQL automatizadas bem como tests de softwares. O objetivo principal é ajudar pessoas a encontrarem conexões significativas na internet, para tanto organizo uma analise dados de perfis para facilitar a identificação dos melhores matches para cada usuário.
É vonlutário e feito em raras horas de folga e tem possibilidades de evoluir para um app real, por isso se tiver interesse em ajudar entre em contato comigo 62 - 996514862
Deixei uma demonstração dos resultados em que primeiro separo homens e mulheres, depois separo por estado (foram criados grupos de whatsapp em algumas cidades com ajuda de vonlutários) e por fim os pares com base em homens que era minoria no cadastro.
Os dados são reais e o formulario_casamento consta com certa de 470 cadastro voluntários e reais.

## Roadmap e Futuras Implementações (como trabalho com testes de softwares pretendo:)

- Desenvolvimento de dashboards para visualização de dados por analistas de relacionamento
- Implementação de testes de software:
  - Testes de API
  - Testes de Contrato
  - Testes de Unidade
- Melhorias no algoritmo de matching
- Integração com redes sociais


Sistema web para captura e análise de perfis de relacionamento com:
- Formulário interativo hospedado no na Hostinger em PHP e futuramente no Heroku
- Banco de dados organizado para análise de compatibilidade
- Algoritmo de matching baseado em múltiplos critérios
- Dashboard de visualização de dados (futura implementação)

## 🔍 Análise de Dados com Pandas

O coração do sistema de matching utiliza Python e Pandas para:

-formulario_casamento.csv é o arquivo geral que vem exportado da Hostinger e primeiramente fiz a separação para dados homens e dados mulheres

```python
import pandas as pd

# Carregar dados
homens = pd.read_csv('dados_homens.csv')
mulheres = pd.read_csv('dados_mulheres.csv')

# Filtragem inicial
def filtrar_combinacoes(base, filtro):
    # Aplicar critérios de idade
    mask = (base['idade'] >= filtro['idade_minima_parceiro']) & \
           (base['idade'] <= filtro['idade_maxima_parceiro'])
    
    # Critério de bebida alcoólica
    if filtro['parceiro_pode_beber'] == 'não':
        mask &= (base['bebida_alcoolica'] == 'não')
    
    # Critério de filhos
    if filtro['parceiro_pode_ter_filhos'] == 'não':
        mask &= (base['tem_filhos'] == 'não')
    
    return base[mask]
```

## 🎯 Sistema de Pontuação

### 1. Critérios de Exclusão
- **Idade**: Fora do intervalo especificado
- **Bebida alcoólica**: Incompatibilidade de preferências
- **Filhos**: Expectativas divergentes

### 2. Matrizes de Pontuação
Implementadas como dicionários em Python:

```python
PONTUACAO_ATIVIDADE_FISICA = {
    ('Diariamente', 'Diariamente'): 7,
    ('Diariamente', '3x por semana'): 4,
    # ... outras combinações
}

PONTUACAO_FRASE_IDENTIFICACAO = {
    ('Vida glamourosa', 'Vida glamourosa'): 7,
    ('Vida glamourosa', 'Experiências e viagens'): 5,
    # ... outras combinações
}
```

## ⚙️ Processo de Matching

1. **Pré-processamento**:
   ```python
   # Converter dados para análise
   homens['idade'] = pd.to_numeric(homens['idade'])
   mulheres['idade'] = pd.to_numeric(mulheres['idade'])
   ```

2. **Combinação e pontuação**:
   ```python
   def calcular_match(homem, mulher):
       pontos = 0
       pontos += PONTUACAO_ATIVIDADE_FISICA.get(
           (homem['atividade_fisica'], mulher['atividade_fisica']), 0)
       
       pontos += PONTUACAO_FRASE_IDENTIFICACAO.get(
           (homem['frase_identificacao'], mulher['frase_identificacao']), 0)
       
       return pontos
   ```

3. **Geração de resultados**:
   ```python
   resultados = []
   for _, homem in homens.iterrows():
       mulheres_filtradas = filtrar_combinacoes(mulheres, homem)
       for _, mulher in mulheres_filtradas.iterrows():
           score = calcular_match(homem, mulher)
           resultados.append({
               'id_homem': homem['id'],
               'id_mulher': mulher['id'],
               'score': score
           })
   
   pd.DataFrame(resultados).to_csv('matches.csv', index=False)
   ```

## 📊 Próximos Passos

1. **Dashboard Analytics**:
   - Visualização de distribuição de matches
   - Análise de clusters de compatibilidade
   - Heatmaps de características mais compatíveis

2. **Testes Automatizados**:
   - Testes de API com pytest
   - Testes de contrato com Pact
   - Testes de unidade para funções de matching

3. **Otimizações**:
   - Implementação de algoritmos mais eficientes
   - Adição de machine learning para melhorar matches
   - Sistema de feedback para ajuste de pesos

## 🛠 Tecnologias Utilizadas

- **Frontend**: HTML5, CSS3, JavaScript (React)
- **Backend**: Python (Flask/Django)
- **Banco de Dados**: PostgreSQL
- **Análise de Dados**: Pandas, NumPy
- **Visualização**: Matplotlib, Seaborn (futuro)
- **Hospedagem**: Heroku
- **Testes**: pytest, unittest

## 📝 Como Contribuir

1. Clone o repositório
2. Instale as dependências: `pip install -r requirements.txt`
3. Crie uma branch para sua feature
4. Envie um pull request com suas melhorias

## 📄 Licença

MIT License - veja [LICENSE](LICENSE) para detalhes.

## 📧 Contato

Equipe de Desenvolvimento - rubemargo@gmail.com
62 996514862
