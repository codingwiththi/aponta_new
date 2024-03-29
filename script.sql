USE [aponta]
GO
/****** Object:  Table [dbo].[Apontamento]    Script Date: 28/02/2020 17:44:48 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Apontamento](
	[Id] [int] IDENTITY(1,1) NOT NULL,
	[Data_inicial] [datetime] NULL,
	[Data_final] [datetime] NULL,
	[data_alteracao] [datetime] NULL,
	[num_chamado] [varchar](50) NULL,
	[FK_atividade_Id] [int] NULL,
	[FK_contrato_Id] [int] NULL,
	[FK_tipo_hora_Id] [int] NULL,
	[FK_func_Id] [int] NULL,
	[FK_status_Id] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[Id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[Atividade]    Script Date: 28/02/2020 17:44:48 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Atividade](
	[Id] [int] IDENTITY(1,1) NOT NULL,
	[nome] [varchar](10) NULL,
	[FK_tipo_ativ_Id] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[Id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[Cliente]    Script Date: 28/02/2020 17:44:48 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Cliente](
	[Id] [int] IDENTITY(1,1) NOT NULL,
	[CNPJ] [varchar](50) NULL,
	[nome] [varchar](80) NULL,
PRIMARY KEY CLUSTERED 
(
	[Id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[Contrato]    Script Date: 28/02/2020 17:44:48 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Contrato](
	[contrato] [varchar](10) NULL,
	[Id] [int] IDENTITY(1,1) NOT NULL,
	[FK_cliente_Id] [int] NULL,
PRIMARY KEY CLUSTERED 
(
	[Id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[Departamento]    Script Date: 28/02/2020 17:44:48 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Departamento](
	[nome] [varchar](100) NULL,
	[Id] [int] IDENTITY(1,1) NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[Id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[Funcionario]    Script Date: 28/02/2020 17:44:48 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Funcionario](
	[displayName] [nvarchar](4000) NULL,
	[SamAccountName] [nvarchar](4000) NULL,
	[userPrincipalName] [nvarchar](4000) NULL,
	[givenName] [nvarchar](4000) NULL,
	[sn] [nvarchar](4000) NULL,
	[Title] [nvarchar](4000) NULL,
	[department] [nvarchar](4000) NULL,
	[company] [nvarchar](4000) NULL,
	[physicalDeliveryOfficeName] [nvarchar](4000) NULL,
	[mail] [nvarchar](4000) NULL,
	[telephoneNumber] [nvarchar](4000) NULL,
	[mobile] [nvarchar](4000) NULL,
	[manager] [nvarchar](4000) NULL,
	[postOfficeBox] [varchar](10) NULL,
	[id] [int] IDENTITY(1,1) NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[status]    Script Date: 28/02/2020 17:44:48 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[status](
	[status] [varchar](50) NULL,
	[id] [int] IDENTITY(1,1) NOT NULL,
PRIMARY KEY CLUSTERED 
(
	[id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[Tipo_atividade]    Script Date: 28/02/2020 17:44:48 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Tipo_atividade](
	[Id] [int] IDENTITY(1,1) NOT NULL,
	[tipo_atividade] [varchar](100) NULL,
PRIMARY KEY CLUSTERED 
(
	[Id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
/****** Object:  Table [dbo].[Tipo_hora]    Script Date: 28/02/2020 17:44:48 ******/
SET ANSI_NULLS ON
GO
SET QUOTED_IDENTIFIER ON
GO
CREATE TABLE [dbo].[Tipo_hora](
	[Id] [int] IDENTITY(1,1) NOT NULL,
	[tipo_hora] [varchar](10) NULL,
PRIMARY KEY CLUSTERED 
(
	[Id] ASC
)WITH (PAD_INDEX = OFF, STATISTICS_NORECOMPUTE = OFF, IGNORE_DUP_KEY = OFF, ALLOW_ROW_LOCKS = ON, ALLOW_PAGE_LOCKS = ON) ON [PRIMARY]
) ON [PRIMARY]

GO
ALTER TABLE [dbo].[Apontamento] ADD  CONSTRAINT [DF_apontamento]  DEFAULT (getdate()) FOR [data_alteracao]
GO
ALTER TABLE [dbo].[Apontamento]  WITH CHECK ADD  CONSTRAINT [FK_atividade] FOREIGN KEY([FK_atividade_Id])
REFERENCES [dbo].[Atividade] ([Id])
GO
ALTER TABLE [dbo].[Apontamento] CHECK CONSTRAINT [FK_atividade]
GO
ALTER TABLE [dbo].[Apontamento]  WITH CHECK ADD  CONSTRAINT [FK_contrato] FOREIGN KEY([FK_contrato_Id])
REFERENCES [dbo].[Contrato] ([Id])
GO
ALTER TABLE [dbo].[Apontamento] CHECK CONSTRAINT [FK_contrato]
GO
ALTER TABLE [dbo].[Apontamento]  WITH CHECK ADD  CONSTRAINT [FK_func] FOREIGN KEY([FK_func_Id])
REFERENCES [dbo].[Funcionario] ([id])
GO
ALTER TABLE [dbo].[Apontamento] CHECK CONSTRAINT [FK_func]
GO
ALTER TABLE [dbo].[Apontamento]  WITH CHECK ADD  CONSTRAINT [FK_status] FOREIGN KEY([FK_status_Id])
REFERENCES [dbo].[status] ([id])
GO
ALTER TABLE [dbo].[Apontamento] CHECK CONSTRAINT [FK_status]
GO
ALTER TABLE [dbo].[Atividade]  WITH CHECK ADD FOREIGN KEY([FK_tipo_ativ_Id])
REFERENCES [dbo].[Tipo_atividade] ([Id])
GO
ALTER TABLE [dbo].[Atividade]  WITH CHECK ADD FOREIGN KEY([FK_tipo_ativ_Id])
REFERENCES [dbo].[Tipo_atividade] ([Id])
GO
ALTER TABLE [dbo].[Atividade]  WITH CHECK ADD FOREIGN KEY([FK_tipo_ativ_Id])
REFERENCES [dbo].[Tipo_atividade] ([Id])
GO
ALTER TABLE [dbo].[Atividade]  WITH CHECK ADD FOREIGN KEY([FK_tipo_ativ_Id])
REFERENCES [dbo].[Tipo_atividade] ([Id])
GO
ALTER TABLE [dbo].[Atividade]  WITH CHECK ADD FOREIGN KEY([FK_tipo_ativ_Id])
REFERENCES [dbo].[Tipo_atividade] ([Id])
GO
ALTER TABLE [dbo].[Atividade]  WITH CHECK ADD FOREIGN KEY([FK_tipo_ativ_Id])
REFERENCES [dbo].[Tipo_atividade] ([Id])
GO
ALTER TABLE [dbo].[Atividade]  WITH CHECK ADD FOREIGN KEY([FK_tipo_ativ_Id])
REFERENCES [dbo].[Tipo_atividade] ([Id])
GO
ALTER TABLE [dbo].[Atividade]  WITH CHECK ADD FOREIGN KEY([FK_tipo_ativ_Id])
REFERENCES [dbo].[Tipo_atividade] ([Id])
GO
ALTER TABLE [dbo].[Atividade]  WITH CHECK ADD FOREIGN KEY([FK_tipo_ativ_Id])
REFERENCES [dbo].[Tipo_atividade] ([Id])
GO
ALTER TABLE [dbo].[Atividade]  WITH CHECK ADD  CONSTRAINT [FK_tipo_ativ] FOREIGN KEY([FK_tipo_ativ_Id])
REFERENCES [dbo].[Tipo_atividade] ([Id])
GO
ALTER TABLE [dbo].[Atividade] CHECK CONSTRAINT [FK_tipo_ativ]
GO
ALTER TABLE [dbo].[Contrato]  WITH CHECK ADD FOREIGN KEY([FK_cliente_Id])
REFERENCES [dbo].[Cliente] ([Id])
GO
