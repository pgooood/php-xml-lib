<?xml version="1.0" encoding="utf-8"?>
<xsl:stylesheet version="1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output media-type="text/html" method="html" omit-xml-declaration="yes" indent="no" encoding="utf-8"/>
	
	<xsl:template match="/">
		<xsl:text disable-output-escaping="yes">&lt;!DOCTYPE HTML&gt;</xsl:text>
		<html>
			<head>
				<title>Hello World!</title>
			</head>
			<body>
				<div clkass="container">
					<h1>Books</h1>
					<xsl:apply-templates/>
				</div>
			</body>
		</html>
	</xsl:template>

	<xsl:template match="book">
		<h2>
			<xsl:text>[</xsl:text>
			<xsl:value-of select="@id" />
			<xsl:text>] </xsl:text>
			<xsl:value-of select="title" />
		</h2>
		<dl>
			<xsl:apply-templates/>
		</dl>
	</xsl:template>

	<xsl:template match="book/*">
		<dt>
			<xsl:value-of select="name()" />
		</dt>
		<dd>
			<xsl:value-of select="text()" />
		</dd>
	</xsl:template>

</xsl:stylesheet>