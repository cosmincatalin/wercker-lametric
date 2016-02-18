package eu.cosminsanda.handlers

import java.io.{ByteArrayOutputStream, ByteArrayInputStream}

import com.amazonaws.services.lambda.runtime.{Context, RequestHandler}

class ProjectChecker extends RequestHandler[Any, Unit] {

    override def handleRequest(input: Any, context: Context): Unit = {

    }
}

object ProjectChecker extends App {



}