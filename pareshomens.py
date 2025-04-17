import pandas as pd

# Carregar os arquivos CSV com as pontuações
frase_identificacao_pontuacao = pd.read_csv('resources/csv/go/frase_identificacao_pontuacao.csv')
atividade_fisica_pontuacao = pd.read_csv('resources/csv/go/atividade_fisica_pontuacao.csv')
estilo_musical_pontuacao = pd.read_csv('resources/csv/go/estilo_musical_pontuacao.csv')

# Função para obter a pontuação de uma combinação
def obter_pontuacao(comb, tabela, col1, col2):
    # Converter as combinações para string e remover espaços extras
    comb = (str(comb[0]).strip(), str(comb[1]).strip())
    # Verificar se as colunas existem na tabela
    if col1 in tabela.columns and col2 in tabela.columns:
        # Filtrar a tabela para encontrar a combinação
        pontuacao = tabela[(tabela[col1].str.strip() == comb[0]) & (tabela[col2].str.strip() == comb[1])]['pontuacao']
        if not pontuacao.empty:
            return pontuacao.values[0]
    # Se não encontrar, retornar 0
    return 0

# Função para calcular a pontuação total e detalhada
def calcular_pontuacao(homem, mulher):
    pontuacao_total = 0
    pontuacao_detalhada = {
        'frase_identificacao': 0,
        'atividade_fisica': 0,
        'estilo_musical': 0
    }
    
    # Pontuação para frase_identificacao
    pontuacao_frase = obter_pontuacao((homem['frase_identificacao'], mulher['frase_identificacao']), frase_identificacao_pontuacao, 'frase1', 'frase2')
    pontuacao_total += pontuacao_frase
    pontuacao_detalhada['frase_identificacao'] = pontuacao_frase
    
    # Pontuação para atividade_fisica
    pontuacao_atividade = obter_pontuacao((homem['atividade_fisica'], mulher['atividade_fisica']), atividade_fisica_pontuacao, 'atividade1', 'atividade2')
    pontuacao_total += pontuacao_atividade
    pontuacao_detalhada['atividade_fisica'] = pontuacao_atividade
    
    # Pontuação para estilo_musical
    pontuacao_estilo = obter_pontuacao((homem['estilo_musical'], mulher['estilo_musical']), estilo_musical_pontuacao, 'estilo1', 'estilo2')
    pontuacao_total += pontuacao_estilo
    pontuacao_detalhada['estilo_musical'] = pontuacao_estilo
    
    return pontuacao_total, pontuacao_detalhada

# Carregar o arquivo CSV com as combinações
file_path = 'resources/csv/pr/pares_homens_limpo.csv'
pares_df = pd.read_csv(file_path)

# Carregar o arquivo CSV com os dados originais
dados_path = 'resources/dados_pr.csv'
dados_df = pd.read_csv(dados_path)

# Mapear os dados das mulheres
mulheres_df = dados_df[dados_df['sexo'] == 'Feminino']

# Criar uma lista para armazenar os pares com pontuação detalhada
pares_com_pontuacao = []

# Calcular as pontuações para cada par
for index, row in pares_df.iterrows():
    homem_id = row['Homem_id']
    homem = dados_df[dados_df['id'] == homem_id].iloc[0]
    for col in pares_df.columns[1:]:
        if pd.notna(row[col]):
            mulher_id = row[col]
            mulher = mulheres_df[mulheres_df['id'] == mulher_id]
            if not mulher.empty:
                mulher = mulher.iloc[0]
                pontuacao_total, pontuacao_detalhada = calcular_pontuacao(homem, mulher)
                pares_com_pontuacao.append({
                    'Homem_id': homem_id,
                    'Mulher_id': mulher_id,
                    'Pontuacao_Total': pontuacao_total,
                    'Pontuacao_Frase_Identificacao': pontuacao_detalhada['frase_identificacao'],
                    'Pontuacao_Atividade_Fisica': pontuacao_detalhada['atividade_fisica'],
                    'Pontuacao_Estilo_Musical': pontuacao_detalhada['estilo_musical']
                })

# Criar um DataFrame com os pares com pontuação detalhada
pares_top_df = pd.DataFrame(pares_com_pontuacao)

# Para cada homem, obter os pares com as 5 maiores pontuações
pares_top5 = []
for homem_id, grupo in pares_top_df.groupby('Homem_id'):
    # Ordenar os pares por pontuação total em ordem decrescente e pegar os 5 melhores
    pares_ordenados = grupo.sort_values(by='Pontuacao_Total', ascending=False).head(5)
    pares_top5.append(pares_ordenados)

# Concatenar os DataFrames de cada homem
pares_top5_df = pd.concat(pares_top5)

# Salvar o DataFrame com os pares com as 5 maiores pontuações e pontuação detalhada no diretório resources
output_path_top = 'resources/csv/pr/pares_homens_top5_detalhado.csv'
pares_top5_df.to_csv(output_path_top, index=False)

print(f"O arquivo de pares de homens com as 5 maiores pontuações e pontuação detalhada foi salvo em {output_path_top}")