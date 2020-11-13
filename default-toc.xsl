<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="2.0"
                xmlns:xsl="http://www.w3.org/1999/XSL/Transform"
                xmlns:outline="http://wkhtmltopdf.org/outline"
                xmlns="http://www.w3.org/1999/xhtml">
  <xsl:output doctype-public="-//W3C//DTD XHTML 1.0 Strict//EN"
              doctype-system="http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"
              indent="yes" />
  <xsl:template match="outline:outline">
    <html>
      <head>
        <title>Indholdsfortegnelse</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <style>
          html,
          body {
            font-size: 10pt;
            font-family: Arial, Helvetica, sans-serif;
            color: #50534d;
          }
          h2 {
            font-size: 2em;
            font-weight: bold;
          }

          .section-type {
            position: relative;
            display: inline-block;

            padding-bottom: 8px;

            font-weight: normal;
            font-size: 1em;
            text-transform: uppercase;
            letter-spacing: 1.45px;

            color: #74766c;
          }
          .section-type::after {
            position: absolute;
            display: block;

            height: 2px;

            right: 0;
            left: 0;
            bottom: 0;

            content: "";

            background-color: #ffde2f;
          }
          .wrapper {
            padding-top: 12px;
            padding-bottom: 12px;
          }

          li {list-style: none;}
          ul {}
          ul {padding-left: 0em;}
          ul ul {padding-left: 2em;}
          a {text-decoration:none; color: #50534d;}

          .divTable{
            display: table;

            width: 100%;
          }
          .divTableRow {
            display: table-row;
          }
          .divTableHeading {
            display: table-header-group;
          }
          .divTableCell,
          .divTableHead {
            display: table-cell;
          }
          .divTableCell { white-space: nowrap; }
          .divTableHeading {
            display: table-header-group;

            font-weight: bold;
          }
          .divTableFoot {
            display: table-footer-group;

            font-weight: bold;
          }
          .divTableBody {
            display: table-row-group;
          }
          .divTableCellLessImportant {
            width: 1%;
          }
          .divTableCellMostImportant {
            width: 100%;
          }
          .divTableCellWithDots {
            color: #fff;
            border-bottom: 1px dashed #979797;
          }
          .section {
            padding-left: 15mm;
            padding-right: 15mm;
          }
        </style>
      </head>
      <body>
        <div class="section section--toc">
          <div class="section-type">Indhold</div>
          <h2>Indholdsfortegnelse</h2>
          <ul><xsl:apply-templates select="outline:item/outline:item"/></ul>
        </div>
      </body>
    </html>
  </xsl:template>
  <xsl:template match="outline:item">
    <li>
      <xsl:if test="@title!=''">
        <div class="wrapper">
          <div class="divTable">
            <div class="divTableBody">
              <div class="divTableRow">
                <div class="divTableCell" style="padding-right: 10px;">
                  <a>
                    <xsl:if test="@link">
                      <xsl:attribute name="href"><xsl:value-of select="@link"/></xsl:attribute>
                    </xsl:if>
                    <xsl:if test="@backLink">
                      <xsl:attribute name="name"><xsl:value-of select="@backLink"/></xsl:attribute>
                    </xsl:if>
                    <xsl:value-of select="@title" />
                  </a>
                </div>
                <div class="divTableCell divTableCellMostImportant divTableCellWithDots">
                  -
                </div>
                <div class="divTableCell" style="padding-left: 10px;">
                  <span>s. <xsl:value-of select="@page" /> </span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </xsl:if>
      <ul>
        <xsl:comment>added to prevent self-closing tags in QtXmlPatterns</xsl:comment>
        <xsl:apply-templates select="outline:item"/>
      </ul>
    </li>
  </xsl:template>
</xsl:stylesheet>
