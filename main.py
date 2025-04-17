import pandas as pd

# Carregar o arquivo CSV
file_path = 'resources/formulario_casamento.csv'
df = pd.read_csv(file_path)

# Separar grupos masculino e feminino
homens = df[df['sexo'] == 'Masculino']
mulheres = df[df['sexo'] == 'Feminino']

# Criar um dicionário para armazenar os pares
pares = {homem['id']: [] for index_h, homem in homens.iterrows()}

# Iterar sobre cada homem
for index_h, homem in homens.iterrows():
    # Iterar sobre cada mulher
    for index_m, mulher in mulheres.iterrows():
        # Verificar se a mulher atende às condições do homem
        if (mulher['idade'] >= homem['idade_minima_parceiro'] and 
            mulher['idade'] <= homem['idade_maxima_parceiro'] and
            (mulher['bebida_alcoolica'] == 'Não Bebo' if homem['parceiro_pode_beber'] == 'Não' else True) and
            (mulher['tem_filhos'] == 'Não' if homem['parceiro_pode_ter_filhos'] == 'Não' else True)):
            if (homem['idade'] >= mulher['idade_minima_parceiro'] and 
                homem['idade'] <= mulher['idade_maxima_parceiro'] and
                (homem['bebida_alcoolica'] == 'Não Bebo' if mulher['parceiro_pode_beber'] == 'Não' else True) and
                (homem['tem_filhos'] == 'Não' if mulher['parceiro_pode_ter_filhos'] == 'Não' else True)):
                # Adicionar a mulher à lista de pares do homem
                pares[homem['id']].append(mulher['id'])

# Criar um DataFrame com os pares
pares_df = pd.DataFrame.from_dict(pares, orient='index').reset_index()
pares_df.rename(columns={'index': 'Homem_id'}, inplace=True)

# Salvar o DataFrame completo no diretório resources
output_path_full = 'resources/csv/pr/pares_homens_full.csv'
pares_df.to_csv(output_path_full, index=False)

# Criar um DataFrame limpo (apenas com combinações existentes)
pares_limpo_df = pares_df[pares_df.iloc[:, 1:].notna().any(axis=1)]

# Salvar o DataFrame limpo no diretório resources
output_path_limpo = 'resources/csv/pr/pares_homens_limpo.csv'
pares_limpo_df.to_csv(output_path_limpo, index=False)

print(f"O arquivo de pares de homens completo foi salvo em {output_path_full}")
print(f"O arquivo de pares de homens limpo foi salvo em {output_path_limpo}")