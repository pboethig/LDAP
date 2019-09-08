<?php
/**
 * This file is part of the FreeDSx LDAP package.
 *
 * (c) Chad Sikorra <Chad.Sikorra@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace FreeDSx\Ldap\Protocol\ServerProtocolHandler;

use FreeDSx\Ldap\Exception\OperationException;
use FreeDSx\Ldap\Operation\Request;
use FreeDSx\Ldap\Operation\ResultCode;
use FreeDSx\Ldap\Protocol\LdapMessageRequest;
use FreeDSx\Ldap\Protocol\LdapQueue;
use FreeDSx\Ldap\Server\RequestContext;
use FreeDSx\Ldap\Server\RequestHandler\RequestHandlerInterface;
use FreeDSx\Ldap\Server\Token\TokenInterface;

/**
 * Handles generic requests that can be sent to the user supplied dispatcher / handler.
 *
 * @author Chad Sikorra <Chad.Sikorra@gmail.com>
 */
class ServerDispatchHandler extends BaseServerHandler implements ServerProtocolHandlerInterface
{
    /**
     * {@inheritDoc}
     */
    public function handleRequest(LdapMessageRequest $message, TokenInterface $token, RequestHandlerInterface $dispatcher, LdapQueue $queue, array $options): void
    {
        $context = new RequestContext($message->controls(), $token);
        $request = $message->getRequest();

        switch ($request) {
            case $request instanceof Request\AddRequest:
                $dispatcher->add($context, $request);
                break;
            case $request instanceof Request\CompareRequest:
                $dispatcher->compare($context, $request);
                break;
            case $request instanceof Request\DeleteRequest:
                $dispatcher->delete($context, $request);
                break;
            case $request instanceof Request\ModifyDnRequest:
                $dispatcher->modifyDn($context, $request);
                break;
            case $request instanceof Request\ModifyRequest:
                $dispatcher->modify($context, $request);
                break;
            case $request instanceof Request\ExtendedRequest:
                $dispatcher->extended($context, $request);
                break;
            default:
                throw new OperationException('The request operation is not supported.', ResultCode::NO_SUCH_OPERATION);
        }

        $queue->sendMessage($this->responseFactory->getStandardResponse($message));
    }
}