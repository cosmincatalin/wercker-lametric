organization := "eu.cosminsanda"

name := "wercker-lametric"

version := "1.0.0"

scalaVersion := "2.11.7"

libraryDependencies += "com.amazonaws" % "aws-lambda-java-core" % "1.1.0"

libraryDependencies += "com.amazonaws" % "aws-lambda-java-log4j" % "1.0.0"

libraryDependencies += "com.fasterxml.jackson.module" %% "jackson-module-scala" % "2.6.3"

libraryDependencies += "org.json4s" %% "json4s-native" % "3.3.0"

assemblyJarName in assembly := name.value + ".jar"

assemblyMergeStrategy in assembly := {
  case "META-INF/org/apache/logging/log4j/core/config/plugins/Log4j2Plugins.dat" => MergeStrategy.concat
  case x =>
    val oldStrategy = (assemblyMergeStrategy in assembly).value
    oldStrategy(x)
}